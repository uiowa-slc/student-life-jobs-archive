$Header
<main class="main-content__container" id="main-content__container">


   $Breadcrumbs
  <div class="grid-container">
    <div class="grid-x align-center grid-padding-x">
      <div class="cell">
        <div class="main-content__header">
          <h1>Search results</h1>
        </div>
      </div>
    </div>
  </div>



$BeforeContent




<div class="grid-container">

  <div class="grid-x grid-padding-x">
      <article class="cell medium-8 large-6 large-centered">
          <div style="padding-top: 20px;">
            $TopicSearchFormSized("medium")
          </div>
        $BeforeContentConstrained


        <% if $JobCats || $JobListings %>
            <% if $JobCats %>
                <div class="topic-browse-by-filter__grid topic-browse-by-filter__grid--large"  data-equalizer>
                    <% loop $JobCats %>
                        <div class="topic-browse-by-filter__item margin-bottom-1" data-equalizer-watch><a href="$Link" class="button hollow secondary button--flex-full button--skinny"><span class="topicholder-cat-inner <% if $ActiveJobListings > 0 %>font-weight-bold <% end_if %>"
                            >$Title&nbsp;<% if $ActiveJobListings > 0 %><span style="topicholder-cat-inner__count">({$ActiveJobListings})</span><% end_if %></span></a></div>
                    <% end_loop %>
                </div>
            <% end_if %>

            <% if $JobListings %>
              <% loop $JobListings %>
                  <% include JobCard %>
              <% end_loop %>
            <% end_if %>

        <% else %>
              <% if $Query %>
                <p style="margin-top: 20px; font-weight: bold;">Sorry, there are no open jobs that matched this search term.</p>
              <% else %>
                <p style="margin-top: 20px; font-weight: bold;">No search term specified. Please specify a search term and try searching again.</p>
              <% end_if %>

        <% end_if %>


      </article>

  </div>
</div>

    $AfterContentConstrained
    $Form



$AfterContent

</main>
