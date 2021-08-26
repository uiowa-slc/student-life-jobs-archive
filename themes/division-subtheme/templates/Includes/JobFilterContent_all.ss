<article class="topic-content">

        <p>The following is a list of all jobs in this category and some positions may not currently be hiring.</p>


    <%-- do special markup when we're filtering by location because we don't need "By Location" in the location filte --%>
    <% if $FilterType == "Location" %>

        <% with $Filter %>

            <% if $JobListings("all") %>
                <% loop $JobListings("all") %>
                    <% include JobCard %>
                <% end_loop %>
            <% else %>
                <p>Sorry, there currently aren't any jobs at this location.</p>
            <% end_if %>
        <% end_with %>

    <%-- for every other filter: --%>
    <% else %>

        <% with $Filter %>

            <% if $Locations("all") %>
                <h3  class="topicholder-section__heading">By Location</h3>

                <% loop $Locations("all") %>
                    <ul class="accordion" data-accordion data-multi-expand="true" data-allow-all-closed="true">

                  <li class="accordion-item count <%if $Up.Locations.Count == 1 %>is-active<% end_if %>" data-accordion-item>

                    <a href="#" class="accordion-title">$Title <span>($JobListingsByFilter("all").Count)</span></a>


                    <% loop $JobListingsByFilter("all") %>
                        <div class="accordion-content " data-tab-content>
                        <% include JobCard %>
                        </div>
                    <% end_loop %>
                  </li>
                  </ul>
                  <% end_loop %>
            <% else_if $JobListings("all") %>
                <% loop $JobListings("all") %>
                    <% include JobCard %>
                <% end_loop %>
            <% else %>

            <p>Sorry, there currently aren't any jobs listed under this category.</p>

            <% end_if %>
        <% end_with %>

    <% end_if %>
            <p><a href="{$Filter.Link}" class="button hollow">Browse only <strong>currently hiring jobs</strong> in "{$Filter.Title}" <i class="fa fa-arrow-right" aria-hidden="true"></i></a></p>
</article>
