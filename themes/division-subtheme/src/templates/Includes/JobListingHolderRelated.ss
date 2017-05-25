<% if $Related %>
<h2>You might also try:</h2>
<ul class="featured-topic-grid row large-up-2">

<% loop $Related %>
  <li class="column column-block">
    <a href="$Link">
    <h3><i class="fa fa-file-o fa-lg fa-fw"></i>$Title</h3>
    	<p class="bloglistitem__category">
			<% loop $Categories.Limit(1) %><span href="$URL" class="bloglistitem__category">$Title</span><% end_loop %>
			<% loop $Departments.Limit(1) %><span href="$URL" class="bloglistitem__category">$Title</span><% end_loop %>
		</p>
    </a>
  </li>
<% end_loop %>
</ul>
<% end_if %>