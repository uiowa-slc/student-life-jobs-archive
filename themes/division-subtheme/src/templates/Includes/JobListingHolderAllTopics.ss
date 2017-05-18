<p class="text-center">Filter jobs:</p>
<ul class="tabs" data-tabs id="example-tabs">
  <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Category</a></li>
  <li class="tabs-title"><a href="#panel2">Department</a></li>
  <li class="tabs-title"><a href="#panel3">All jobs by title</a></li>
</ul>


<div class="tabs-content" data-tabs-content="example-tabs">
  <div class="tabs-panel is-active" id="panel1">
    <h2>Job listings by category:</h2>
      <div class="row large-up-3"> 
        <% loop $AllCats %>
          <div class="column column-block">
            <h3>$Title</h3>
            <% if $BlogPosts %>
                <ul class="job-list">
                <% loop $BlogPosts %>
                  <li class="job-list__item"><i class="fa fa-file" aria-hidden="true"></i> <a href="$Link">$Title</a></li>
                <% end_loop %>
                </ul>
              <% else %>
                <p>No jobs are currently listed.</p>
            <% end_if %>
          </div>
        <% end_loop %>
      </div>
  </div>
  <div class="tabs-panel" id="panel2">
    <h2>Job listings by department:</h2>
      <% loop $AllCats %>
        <h3>$Title</h3>
        <% if $BlogPosts %>
            <div class="row large-up-3"> 
              <% loop $BlogPosts %>
                <div class="column column-block"><i class="fa fa-file" aria-hidden="true"></i> <a href="$Link">$Title</a></div>
              <% end_loop %>
            </div>
          <% else %>
            <p>No jobs are currently listed.</p>
        <% end_if %>
      <% end_loop %>
  </div>
  <div class="tabs-panel" id="panel3">
    <h2>All job listings by title</h2>
      <div class="row large-up-3"> 
        <% loop $BlogPosts %>
          <div class="column column-block"><i class="fa fa-file" aria-hidden="true"></i> <a href="$Link">$Title</a></div>
        <% end_loop %>
      </div>
  </div>
</div>

















