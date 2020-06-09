
      <section class="topicholder-section topicholder-section--gray">
        <div class="grid-container grid-container--wpadding">
          <div class="grid-x grid-padding-x">
            <div class="cell small-12 large-1 show-for-medium"></div>
            <div class="cell large-11">

                  <h2 class="topicholder-section__heading">Browse all open positions by category</h2>


                 <ul class="topicholder-all-list">
                   <% loop $Categories.Sort('Title ASC') %>
                      <li class="topicholder-all-list__item topicholder-all-list__item--avoid-break"><h3 class="topicholder-all-list__item-heading"><a href="$Link">$Title</a></h3>
                        <% if $JobListings %>
                        <ul class="topicholder-sublist">
                          <% loop $JobListings.Sort('Title ASC') %>
                            <li class="topicholder-sublist__item"><a href="$Link">$Title</a></li>
                          <% end_loop %>
                        </ul>
                      <% end_if %>
                        </li>
                    <% end_loop %>

                </ul>
            </div>
          </div>
        </div>

      </div>

      <section class="topicholder-section topicholder-section--gray">
        <div class="grid-container grid-container--wpadding">
          <div class="grid-x grid-padding-x">
            <div class="cell small-12 medium-1 hide-for-large"></div>
            <div class="cell medium-11">

                  <h2 class="topicholder-section__heading">Browse all open positions by department</h2>


                 <ul class="topicholder-all-list">
                   <% loop $Departments.Sort('Title ASC') %>
                      <li class="topicholder-all-list__item topicholder-all-list__item--avoid-break"><h3 class="topicholder-all-list__item-heading"><a href="$Link">$Title</a></h3>
                        <% if $JobListings %>
                        <ul class="topicholder-sublist">
                          <% loop $JobListings.Sort('Title ASC') %>
                            <li class="topicholder-sublist__item"><a href="$Link">$Title</a></li>
                          <% end_loop %>
                        </ul>
                      <% end_if %>
                        </li>
                    <% end_loop %>

                </ul>
            </div>
          </div>
        </div>

      </div>

