function loadQuiz(widget_role_url, lang) {
 var jqxhr = $.ajax( "http://virtus-vet.eu/src/php/widget_data_quiz.php?widget_role_url=" + encodeURI(widget_role_url) + "&lang=" + lang )
 .done(function(data) {
   data = JSON.parse(data)
   renderQuiz(data)
   loadSubmissions(data["id"])
   showQuestion(-1)
 })
 .fail(function() {
     $("#main-content").html("Could not load quiz.")
 });
}

var questionCount = 0;

function renderQuiz(data) {
  $('.quiz-title').html(data.title)

  $('.btn-next').click(function() {
    showQuestion(0)
  })

  $('.total-count').html(data.questions.length)

  data.questions.forEach(function(q) {
    var questionTpl = $($('#question-template').html())
    $('.questions').append(questionTpl)
    var qIdx = questionCount;
    questionCount++;

    questionTpl.find('.question-title').html(q.title + " (" + (qIdx+1) + "/" + data.questions.length + ")")
    questionTpl.attr('id', 'question-' + q.id)
    questionTpl.attr('data-idx', qIdx)

    questionTpl.find('.btn-submit').click(function() {
      postSubmission(data.id, q.id)
    })
    questionTpl.find('.btn-prev').click(function() {
      showQuestion(qIdx-1)
    })
    questionTpl.find('.btn-next').click(function() {
      showQuestion(qIdx+1)
    })
    questionTpl.find('.btn-overview').click(function() {
      showQuestion(-1)
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

function renderSubmissions(data) {
  // TODO
  var submitted = 0
  var correct = 0


  for (var i = 0; i < data.length; i++) {
    if (data[i].submitted) {
      submitted++

      var q_correct = true;

      var questionTpl = $('#question-' + data[i].question)

      Object.keys(data[i].answers).forEach(function(aid) {
        questionTpl.find('input[name="answer-'+aid+'"]').prop('checked', data[i].answers[aid].checked)
        if (data[i].answers[aid].checked != data[i].answers[aid].correct) {
          questionTpl.find('#answer-'+aid).find('.wrong').show()
          q_correct = false;
        }
        else {
          questionTpl.find('#answer-'+aid).find('.right').show()
        }
      });
      questionTpl.find('input').prop('disabled', true)
      questionTpl.find('.btn-submit').prop('disabled', true)

      if (q_correct) {
        correct++
      }
    }
  }

  $('.submitted-count').html(submitted)
  $('.correct-count').html(correct)
}

function showQuestion(idx) {
  if (idx < 0) idx = -1
  else if (idx >= questionCount) idx = -1

  if (idx != -1) {
    $('.question').hide()
    $('.overview').hide()
    $('.question[data-idx='+idx+']').show()
  }
  else {
    $('.question').hide()
    $('.overview').show()
  }
}

function extractSubmission(question_id) {
  var data = {}
  $('#question-'+question_id+' input[type=checkbox]').each(function() {
    var split = $(this).attr('name').split('-')
    data[split[1]] = {"checked": $(this).prop('checked')}
  })

  return {"answers": data, "question": question_id}
}

function loadSubmissions(quiz_id) {
 $.ajax( {
  url: "http://virtus-vet.eu/src/php/widget_data_quiz_submissions.php?quiz_id=" + quiz_id,
  crossDomain: true,
  xhrFields: {
    withCredentials: true
  }
 } )
 .done(function(data) {
   data = JSON.parse(data)
   renderSubmissions(data)
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

function postSubmission(quiz_id, question_id) {
  $('question-' + question_id + ' .btn-submit').prop('disabled', true);
  $.ajax( {
    method: "POST",
    url: "http://virtus-vet.eu/src/php/widget_data_quiz_submissions.php?store&quiz_id=" + quiz_id,
    crossDomain: true,
    xhrFields: {
      withCredentials: true
    },
    data: JSON.stringify(extractSubmission(question_id))
  })
  .done(function(data) {
    data = JSON.parse(data)
    renderSubmissions(data)
  })
  .fail(function() {
    $("#main-content").html("Could not store submission.")
  });
}
