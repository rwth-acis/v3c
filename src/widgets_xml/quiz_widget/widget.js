function loadQuiz(widget_role_url, lang) {
 var jqxhr = $.ajax( "http://virtus-vet.eu/src/php/widget_data_quiz.php?widget_role_url=" + encodeURI(widget_role_url) + "&lang=" + lang )
 .done(function(data) {
   data = JSON.parse(data)
   renderQuiz(data)

   showQuestion(0)
 })
 .fail(function() {
     $("#main-content").html("Could not load quiz.")
 });
}

var questionCount = 0;

function renderQuiz(data) {
  $('.quiz-title').html(data.title)

  data.questions.forEach(function(q) {
    var questionTpl = $($('#question-template').html())
    $('.questions').append(questionTpl)
    var qIdx = questionCount;
    questionCount++;

    questionTpl.find('.question-title').html(q.title + " (" + (qIdx+1) + "/" + data.questions.length + ")")
    questionTpl.attr('id', 'question-' + q.id)
    questionTpl.attr('data-idx', qIdx)

    questionTpl.find('.btn-submit').click(function() {
      postSubmission(q.id)
    })
    questionTpl.find('.btn-prev').click(function() {
      showQuestion(qIdx-1)
    })
    questionTpl.find('.btn-next').click(function() {
      showQuestion(qIdx+1)
    })

    q.answers.forEach(function(a) {
      var answerTpl = $($('#answer-template').html())
      questionTpl.find('.answers').append(answerTpl)

      answerTpl.attr('id', 'answer-'+a.id)
      answerTpl.find('.answer-title').html(a.title)
      answerTpl.find('input').attr('name', 'answer-'+a.id)
      answerTpl.find('input').attr('id', 'cb-answer-'+a.id)
      answerTpl.find('label').attr('for', 'cb-answer-'+a.id)
    })
  })
}

function renderSubmission(data) {
  if (data.submitted) {
    var questionTpl = $('#question-' + data.question)

    Object.keys(data.answers).forEach(function(aid) {
      questionTpl.find('input[name="answer-'+aid+'"]').prop('checked', data.answers[aid].checked)
      if (data.answers[aid].checked != data.answers[aid].correct) {
        questionTpl.find('#answer-'+aid).find('.wrong').show()
      }
      else {
        questionTpl.find('#answer-'+aid).find('.right').show()
      }
    });
    questionTpl.find('input').prop('disabled', true)
    questionTpl.find('.btn-submit').prop('disabled', true)
  }
}

function showQuestion(idx) {
  if (idx < 0) idx = questionCount - 1
  else if (idx >= questionCount) idx = 0
  $('.question').hide()
  $('.question[data-idx='+idx+']').show()

  var question_id = $('.question[data-idx='+idx+']').attr('id').split('-')[1]
  loadSubmission(question_id)
}

function extractSubmission(question_id) {
  var data = {}
  $('#question-'+question_id+' input[type=checkbox]').each(function() {
    var split = $(this).attr('name').split('-')
    data[split[1]] = {"checked": $(this).prop('checked')}
  })

  return {"answers": data, "question": question_id}
}

function loadSubmission(question_id) {
 $.ajax( {
  url: "http://virtus-vet.eu/src/php/widget_data_quiz_submissions.php?question_id=" + question_id,
  crossDomain: true,
  xhrFields: {
    withCredentials: true
  }
 } )
 .done(function(data) {
   data = JSON.parse(data)
   renderSubmission(data)
 })
 .fail(function(xhr) {
    if (xhr.status == 403) {
      $("#main-content").html('Please sign in at <a href="http://virtus-vet.eu">virtus-vet.eu</a> and reload this page!')
    }
    else {
      $("#main-content").html("Could not load submission.")
    }
 });
}

function postSubmission(question_id) {
  $('question-' + question_id + ' .btn-submit').prop('disabled', true);
  $.ajax( {
    method: "POST",
    url: "http://virtus-vet.eu/src/php/widget_data_quiz_submissions.php?store&question_id=" + question_id,
    crossDomain: true,
    xhrFields: {
      withCredentials: true
    },
    data: JSON.stringify(extractSubmission(question_id))
  })
  .done(function(data) {
    data = JSON.parse(data)
    renderSubmission(data)
  })
  .fail(function() {
    $("#main-content").html("Could not store submission.")
  });
}
