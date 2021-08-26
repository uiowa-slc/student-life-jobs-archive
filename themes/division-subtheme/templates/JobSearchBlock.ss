<section class="content-block__container">
      <% if $BackgroundImage %>
      <div class="background-image" data-interchange="[$BackgroundImage.FocusFill(600,400).URL, small], [$BackgroundImage.FocusFill(1600,500).URL, medium]">
        <div class="column row">
          <div class="background-image__header background-image__header--has-content">
            <h1 class="background-image__title text-center">$Title</h1>
            <div class="topic-search__container row">
              <div class="large-9 columns large-centered">
                <h2 class="text-center"><% if $JobListingHolder.Heading %>$JobListingHolder.Heading <% else %>Search for a job below:<% end_if %></h2>
                  $TopicSearchForm

                <p class="text-center"><a href="$JobListingHolder.Link" class="button button--hollow">Browse all jobs</a></p>
          </div>
              </div>
            </div>
          </div>
        </div>
     </div>
   <% end_if %>
  <div class="content-block row column">

        <div class="topic-search__container row">
          <div class="large-9 columns large-centered">

            <% if not $BackgroundImage %>
            <h2 class="text-center"><% if $JobListingHolder.Heading %>$JobListingHolder.Heading <% else %>Search for a topic below:<% end_if %></h2>
                $TopicSearchFormSized
              <% end_if %>

        </div>

  </div>
</section>
