# speedreader

Try it out here: https://speedreader-1434872.herokuapp.com/

## Getting Started
To get this running locally, you'd have to either have
vagrant with homestead running or install the needed dependencies.

## Overview 
This assignment is heavily inspired by this [one](http://nifty.stanford.edu/2015/posera-speed-reader/speed_reader.html) (yes, I nifty assignments!). From the original source:

Many modern speed reading techniques are based on the insights of school teacher Evelyn Wood. In the 1950s, Wood observed that, among other things, (1) using your finger or some
other pointing device to train your eyes and focus while reading and (2) eliminating [subvocalization](http://en.wikipedia.org/wiki/Subvocalization), internally speaking words while reading them, can dramatically increase your reading speed.

Since then, countless speed reading courses have been developed to help students develop these skills. However, these courses rely on the student's discipline to develop good reading habits, and it is easy for an untrained student to learn &quot;the wrong way&quot; and thus never seen the purported benefits of speed reading. Computer programs in this context can act a tutor or personal support system, ensuring that students practice the right skills even while learning
alone.

[Rapid Serial Visual Presentation (RSVP)](http://en.wikipedia.org/wiki/Rapid_Serial_Visual_Presentation), in essence, takes these ideas of pointing-while- reading and removing subvocalization to their limit. With RSVP, a series of objects—here, words—are
presented quickly in succession. By design, the reader is only able to focus on a single word at a time. And furthermore, the words appear at such a speed that the reader is unable to
subvocalize like normal. Such a presentation style is only really practical with a computer program!

In this assignment, you will create an application similar to [Spritz](http://spritzinc.com/), as shown below (ctrl-click on the
image to see the animation)

![img](https://lh5.googleusercontent.com/3OOD_gFjbU-TJ4oXCSz9JXVMy6mottevDQ1fDftk-g6_wGV-MDVxtJHiEF8fCC6dYC_n9fKDnBZ_U9Qb0Dwfnf9eJdgXkoSKWZ_W0NF682hdcJcqIZwTzfaxKLxq_NrOkpK6rEsi3e7fjAxFdg)

The main highlights of the application:

- a user logs in
- the user resumes reading a book from where they left off, at the speed (words per minute) at which  they were 
- new users start at the beginning of the book, at a slow pace (50 words per minute). 
- At any point, the user can change the speed setting 

There are three aspects to this assignment. The breakdown is conceptual: you may have multiple files, and files with a mix of both server and client-side logic:

## Preparation (written in PHP)

- prepare the database table(s). This application has authentication, so use best practices. 

WARNING: **user is a reserved word in Postgres SQL syntax, so use a different column name.**

- seed a line table with lines from a book. This [etext](http://www.textfiles.com/etext/) site has ascii version of texts from [Project Gutenberg](https://www.gutenberg.org/). I chose [Aesop's Fables Translated by George Fyler Townsend](http://www.textfiles.com/etext/FICTION/aesop11.txt). In this book, a paragraph is delimited by an empty line.
- In a console application, read the file, break it up into lines, and populate your database. Keep the empty lines between lines in order to be able to potentially code the optional improvement below. But don’t not keep more than 1 consecutive empty line (i.e., ignore any subsequent empty line until reach a line with characters), and ignore any leading empty lines (remember to trim first).
- Recall that `file_get_contents($url)` returns a string with the entire contents. You can then explode the string based on end-of-line character (use the constant `PHP_EOL`). Alternatively, ` fopen($url, ‘r’)` gets a handle to the file, which you can then use to get lines `(fgets($handle))`, and `feof($handle)` indicates if you reach the end of the file.

## Web Application Server Side (PHP)

- implement a start page with authentication (registration and login per best practices). Once authenticated, you can redirect to the ajax-enabled page, or use the same script.
- Javascript will send Ajax requests for the next line. If the user just registered, start with the first lines of the text at the first speed (100 wpm). Only send back lines with words, unless you decide to implement the ==optional improvement==.
- if the user has used the service before, send the next line to read at the speed they last used (i.e., last speed is persisted). 

NOTE: **In order to keep a speed integer encoded as an integer, use the `JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT` options with `json_encode`.**

- PHP updates the line number saved in the database to the last line sent.
- every time the user changes the speed, PHP must respond to an AJAX request, and save the new speed. The response is unimportant, but send one anyways!

## Web Application client side (html & js)

- the presentation is an element containing the word, a number input to change speed (with minimum of 50 and maximum of 2000, step of 50). ==Optionally add a start/pause button==

- using Ajax, request a line when the page loads. Request a line every time it finishes displaying the last token. 

- get the AJAX response, and break the line into tokens: a token is a single word separate by whitespace (which includes both spaces and line breaks). 

TIP: **Look into the [split](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/split) or [match](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/match) methods**

- get the speed in the AJAX response. Display each token in succession with a delay between tokens. 

TIP: **The [setInterval](https://developer.mozilla.org/en-US/docs/Web/API/WindowOrWorkerGlobalScope/setInterval) will help achieve the words-per-minute rate. This [link](https://stackoverflow.com/questions/4548034/create-a-pause-inside-a-while-loop-in-javascript) and this [link](https://stackoverflow.com/questions/8421998/setinterval-with-loop-time)**

- show you how to invoke methods with a delay and how to clearInterval once you finish with displaying a line. You can ask for the next line in an AJAX request when you clear the interval.

- If the user changes the numeric, send an AJAX request to the PHP script (HINT: look at the oninput event on the numeric input box); note that the Ajax response is not important. Also note that you don’t have to change the speed for the line in progress, just the next one.

- When displaying each token:

  - choose a monospaced font

  - have the text left-justified

  - choose a focus letter based off the length of the token and “center” the word around the focus letter (not really centered, see algorithm below): 

    ```php
    <?php
    length = 1 => 1st letter    // ____a or 4 spaces before 
    length = 2-5 => 2nd letter  // ___four or 3 spaces before
    length = 6-9 => third letter      // __embassy 2 spaces
    length = 10-13 => fourth letter   // _playground 1 spaces
    length >13 => fifth letter        // acknowledgement no spaces
    ```

HINT: **the css rule [white-space: pre](https://developer.mozilla.org/en-US/docs/Web/CSS/white-space) will preserve the whitespace.**

* colour the focus letter differently from the other letters (i.e., the focus letter is red, everything else is black. 
* ==optional improvement==: if the token ends with a punctuation mark (period, question mark, exclamation mark, comma or semi-colon) wait two times longer than normal before displaying the next word. At the end of the paragraph, wait 4 times longer
* ==optional improvement==: add start and pause buttons instead of starting on window load

You can decide on the AJAX query protocol (i.e., Ajax with GET or POST, the url, the request name-value pairs) as well as the encoding and content of the response generated by PHP (i.e., json or xml) (although I strongly recommend json). Please document your interface using a template similar to the one found [here](https://gist.github.com/iros/3426278).

Make sure that you indicate clearly that the source of the text from http://www.textfiles.com/etext based on Project Gutenberg visibly on the web page.

Recall that we set up the url reader.app in Homestead.yaml and etc/hosts. This means you can work on your project in `H:/PHPCode/reader`.

NOTE: **All major browser vendors now recommend Mozilla’s MDN Web Docs as the primary source for Web API documentation (HTML, CSS, JS, browser compatibility).**

## Submission

This is an **individual** project! You must submit a softcopy of the entire project, including the interface documentation. ==You will also push to Heroku==! Please add me as a collaborator, and indicate the Heroku URL in your Lea submission.

WARNING: **If you require PHP 7 features (e.g., null coalescing operator, spaceship operator), you must create a composer.json file indicating the minimum PHP version; Heroku defaults to PHP 5.6.x, which is ok for the vast majority of our code. See me for help!**

