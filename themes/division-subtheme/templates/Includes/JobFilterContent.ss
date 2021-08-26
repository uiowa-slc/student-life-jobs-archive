<article class="topic-content">

<%-- do unique markup when we're filtering by location because we don't need "By Location" in the location filter --%>
    <% if $FilterType == "Location" %>

        <% with $Filter %>
            <% if $JobListings %>
                <% loop $JobListings %>
                    <% include JobCard %>
                <% end_loop %>
            <% else %>
                <p>There currently aren't any hiring jobs listed at {$Title}.</p>
            <% end_if %>
        <% end_with %>

    <%-- for every other filter: --%>
    <% else %>

        <% with $Filter %>
            <% if $Locations %>
                <h3  class="topicholder-section__heading">By Location</h3>



                <% loop $Locations %>
                <ul class="accordion" data-accordion data-multi-expand="true" data-allow-all-closed="true">
                  <li class="accordion-item count <%if $Up.Locations.Count == 1 %>is-active<% end_if %>" data-accordion-item>

                    <a href="#" class="accordion-title" style="">$Title <span class="<% if $ActiveJobListings > 0 %>font-weight-bold<% end_if %>">({$JobListingsByFilter.Count})</span></a>


                    <div class="accordion-content" data-tab-content>
                        <% loop $JobListingsByFilter %>

                            <% include JobCard %>

                        <% end_loop %>
                    </div>
                  </li>

                </ul>
                <% end_loop %>

            <% else %>
                <p>There currently aren't any hiring jobs listed under "{$Title}."</p>

            <% end_if %>
        <% end_with %>

    <% end_if %>


      <% if $FilterOpenClosed != "all" %>
        <p><a href="{$Filter.Link}/all" class="button hollow">Browse <strong>all jobs</strong> in "{$Filter.Title}" (hiring or not) <i class="fas fa-arrow-right"></i></a></p>
      <% end_if %>
</article>
