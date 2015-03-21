<header>
  <h1>Server Side Mustard Cutting</h1>
  <p>For simplicities sake, our mustard-cut here will be a measuring of the screen width. But it could test for <em>anything</em> client-side. We're also using PHP here because easy, but it could be any server side language.</p>
  <p><a href="https://github.com/chriscoyier/server-side-mustard-cut">GitHub Repo</a></p>
</header>

<h2>The Problem</h2>

<ul>
  <li>I want to make a distinction between large screens and small screens (just an example mustard cut).</li>
  <li>I do not want to UA sniff to do this.</li>
  <li>If I just needed some different CSS or JavaScript, I could cut the mustard in JavaScript and conditionally load <a href="https://github.com/filamentgroup/loadCSS">different</a> <a href="https://github.com/filamentgroup/loadJS">resources</a>.</li>
  <li>It's too hard to load entirely different HTML, CSS, and JavaScript in one base document at one URL, purely client-side.</li>
  <li>I want to serve a different document, server side, that has all the correct resources in it.</li>
  <li>I want to make that server-side distinction with client-side mustard-cutting information.</li>
</ul>

<h2>Caveat</h2>

<p>I'm not saying this is the best possible solution. I am saying this seems reasonable to me and I'm using it in production.</p>

<p>This kind of thing has been <a href="https://github.com/jamesgpearce/modernizr-server">approached before</a>. These things aren't necessarily mutually exclusive.</p>

<h2>The Plan</h2>

<ul>
  <li>Let's assume there is a cookie available that has all the client side information we want in it.</li>
  <li>Server-side, we're all set, we'll use that cookie to serve the correct document. Yay!</li>
  <li>If that cookie is <strong>not</strong> there and the browser <strong>does</strong> support cookies (tested at the very top of the document):
    <ol>
      <li>Mustard cut and save the data to a cookie with JavaScript</li>
      <li>Halt the page from loading/doing anything else</li>
      <li>Refresh the page</li>
      <li>Upon refresh, the cookie will be there for the server</li>
    </ol>
  </li>
  <li>If that cookie is not there and the browser <strong>does not</strong> support cookies (or they are turned off): assume one way or the other which document to load.</li>
  <li>If the JavaScript doesn't run: assume one way or another which document to load.</li>
  <li><strong>Important things</strong>: 1) under no circumstances should any browser go into a reload loop. 2) Even on a first-load, this should feel fast.</li>
</ul>

<h2>Possible Scenarios</h2>

<ul>
  <li><strong>The normal first time visitor</strong>: No cookie is present. Mustard cut script will run and refresh quickly. They will get correct document based on cut.</li>
  <li><strong>The repeat visitor</strong>: Cookie is already present. They will get correct document based on cut.</li>
  <li><strong>Visitor with incorrect cookie</strong>: Perhaps they have a desktop browser but it was very narrow when the page loaded the first time, but they have since widened it. We can detect that with a CSS @media query and offer a link to correct the problem.</li>
  <li><strong>Visitor with cookies off</strong>: We serve our choice of documents. Could potentially be wrong. Serve the best likely case based on data.</li>
  <li><strong>Visitor in which JavaScript doesn't run</strong>: We serve our choice of documents. Could potentially be wrong. Serve the best likely case based on data.</li>
</ul>

<h2>The Code</h2>

<p>Server side:</p>

<pre><code>&lt;?php

  <span>// This is just a FAKE ROUTER</span>
  <span>// Do this however your site does routing</span>

  if (isset($_COOKIE[&quot;screen-width&quot;])) {

    <span>// Large screen</span>
    if ($_COOKIE[&quot;screen-width&quot;] &gt; 700) {

      include_once(&quot;screen-large.php&quot;);

    <span>// Small screen</span>
    } else {

      include_once(&quot;screen-small.php&quot;);

    }

  <span>// Choose a default</span>
  } else {

    include_once(&quot;screen-small.php&quot;);

  }

?&gt;</code></pre>

<p>In the document that gets served, if the cookie isn't already present, run the mustard cutting script:</p>

<pre><code>&lt;?php
  <span>// Run this script as high up the page as you can,
  // but only if the cookie isn&#39;t already present.</span>
  if (!isset($_COOKIE[&quot;screen-width&quot;])) { ?&gt;
    &lt;script src=&quot;mobile-mustard.js&quot;&gt;&lt;/script&gt;
&lt;?php } ?&gt;</code></pre>

<p>The script is:</p>

<pre><code>(function() {

  <span>// If the browser supports cookies and they are enabled</span>
  if (navigator.cookieEnabled) {

    <span>// Set the cookie for 3 days</span>
    var date = new Date();
    date.setTime(date.getTime() + (3 * 24 * 60 * 60 * 1000));
    var expires = "; expires=" + date.toGMTString();

    <span>// This is where we&#39;re setting the mustard cutting information.
    // In this case we&#39;re just setting screen width, but it could
    // be anything. Think http://modernizr.com/</span>
    document.cookie = "screen-width=" + screen.width + expires + "; path=/";

    <span>/*
      Only refresh if the WRONG template loads.

      Since we&#39;re defaulting to a small screen,
      and we know if this script is running the
      cookie wasn&#39;t present on this page load,
      we should refresh if the screen is wider
      than 700.

      This needs to be kept in sync with the server
      side distinction
    */</span>
    if (screen.width &gt; 700) {

      <span>// Halt the browser from loading/doing anything else.</span>
      window.stop();

      <span>// Reload the page, because the cookie will now be
      // set and the server can use it.</span>
      location.reload(true);

    }

  }

}());</code></pre>

<p class="final">୧༼ʘ̆ںʘ̆༽୨</p>
