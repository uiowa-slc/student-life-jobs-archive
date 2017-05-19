
<h2>You might also like:</h2>
  <ul class="featured-topic-grid row large-up-2">

  <% loop $BlogPosts.Sort('RAND()').Limit(4) %>
    <li class="column column-block">
      <a href="$Link">
      <h3><i class="fa fa-file-o fa-lg fa-fw"></i>$Title</h3>
      <p>Lorem ipsum test estt tewafd sdf adsf sadf s ....</p>
<%--       <p>$Content.LimitCharacters(100)
      <% if $Categories %>
        
        <% loop $Categories %>
          $Title <% if not $Last %>, <% end_if %>

        <% end_loop %>

      <% end_if %>
      </p> --%>
      </a>
    </li>
  <% end_loop %>
  </ul>