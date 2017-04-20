# ROLE customization

Edit `/webapps/role-uu-prototype/script/role/view/space.js` and insert at the end of `activate` function:

``` javascript
setTimeout(function() {
  if (window.location.hash && window.location.hash.startsWith("#activity=")) {
    $('a[href="' + window.location.hash.substring("#activity=".length) + '"]').click()
  }
}, 1000);
```
