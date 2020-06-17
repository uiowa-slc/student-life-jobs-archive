<article class="topic-content">
  <% if $Content %>

    <div class="main-content__text">
    $Content
    </div>

    <h2 class="topic-related-header" style="margin-bottom: 0;">Jobs listed under &ldquo;{$Title}&rdquo;:</h2>


  <% end_if %>
    <% if $FilterOpenClosed == "all" %>
        <p>The following is a list of all jobs in this category and some jobs may not currently be hiring.</p>
        <p><a href="{$FilterObject.Link}" class="button">See only the currently hiring jobs in this category.</a></p>
    <% end_if %>
  <% if $FilterList %>
    <% loop $FilterList.Sort('LastEdited') %>

        <% include JobCard %>
    <% end_loop %>
  <% else %>
      <p style="margin-top: 20px;">There currently aren't any jobs listed under this category.</p>


  <% end_if %>

      <% if $FilterOpenClosed != "all" %>
        <p><a href="{$FilterObject.Link}/all" class="button">See all jobs in this category (hiring or not).</a></p>
      <% end_if %>
</article>
