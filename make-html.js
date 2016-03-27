var linkcheck = require('metalsmith-linkcheck');
var markdown = require('metalsmith-markdown');
var replace = require('metalsmith-text-replace');
var fs = require('fs-extra');
var googleAnalytics = require('metalsmith-google-analytics').default;
var layouts = require('metalsmith-layouts');

fs.removeSync('./index.html');

require('metalsmith')(__dirname)
  .concurrency(100)

  .use(markdown({
    smartypants: true,
    gfm: true,
    tables: true
  }))
  .ignore('Application')
  .source('.')
  .destination('./html')
  .use(replace({
    '**/*.html': {
      find: /href=".*?\.md"/gi,
      replace: function(match) {
        if (match.startsWith('http'))
          return match;

        return match.replace(/\.md/, '.html');
      }
    }
  }))
  .use(replace({
    'Readme.html': {
      find: /href=".*?\.html"/gi,
      replace: function(match) {
        if (match.startsWith('http') || match.indexOf('Application') > -1)
          return match;

        return match.replace(/href="/, 'href="html/');
      }
    }
  }))
  .use(replace({
    '**/*.html': {
      find: /src=".*? =\d+x"/gi,
      replace: function(match) {
        var width = match.match(/ =(\d+?)x/);

        return match.replace(/ =(\d+?)x/, '" width="' + width[1] + 'px"');
      }
    }
  }))
  .use(replace({
    '**/*.html': {
      find: /<table/gi,
      replace: function(match) {
        return match.replace(/<table/, '<table class="table table-striped"');
      }
    }
  }))
  .use(layouts({
    engine: "handlebars",
    default: "layout.html",
    pattern: '**/*.html' 
  }))
//  .use(googleAnalytics('UA-41219645-3'))
//  .use(linkcheck())
  .build(function (err) {
    if(err)
      return console.log(err);

    fs.move('./html/Readme.html', './index.html', function(){});

  });
