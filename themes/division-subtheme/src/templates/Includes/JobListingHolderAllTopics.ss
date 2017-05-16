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
