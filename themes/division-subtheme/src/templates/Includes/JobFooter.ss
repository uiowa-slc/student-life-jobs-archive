
  <section class="topicholder-featured topicholder-section topicholder-section--light-gray">
      <div class="grid-container grid-container--wpadding">
        <div class="grid-x grid-padding-x">
            <div class="cell small-12 large-1 show-for-medium"></div>
            <div class="cell large-11">
                  <h2 class="topicholder-section__heading">Recently updated jobs</h2>
                <% end_if %>

                <div class="grid-x grid-padding-x small-up-2">
                  <% loop $JobListings.Limit(4).Sort('LastEdited DESC') %>
                    <% include JobCardSummary %>
                  <% end_loop %>
                </div>


            </div>
          </div>

    </div>
</section>

