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

                <ul class="accordion" data-accordion data-multi-expand="true" data-allow-all-closed="true">

                <% loop $Locations %>
                  <li class="accordion-item count <%if $Up.Locations.Count == 1 %>is-active<% end_if %>" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title" style="">$Title <span class="<% if $ActiveJobListings > 0 %>font-weight-bold<% end_if %>">($JobListingsByFilter.Count)</span></a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->

                    <% loop $JobListingsByFilter %>
                        <div class="accordion-content " data-tab-content>
                        <% include JobCard %>
                        </div>
                    <% end_loop %>
                  </li>
                  <% end_loop %>
                  <!-- ... -->
                </ul>
            <% else %>
                <p>There currently aren't any hiring jobs listed under "{$Title}."</p>

            <% end_if %>
        <% end_with %>

    <% end_if %>


      <% if $FilterOpenClosed != "all" %>
        <p><a href="{$Filter.Link}/all" class="button hollow"><i class="fa fa-list" aria-hidden="true"></i> See all jobs in this category (hiring or not).</a></p>
      <% end_if %>
</article>
