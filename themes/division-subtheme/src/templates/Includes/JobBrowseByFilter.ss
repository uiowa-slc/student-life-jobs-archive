  <div class="topic-browse-by-filter">

      <% if $Categories || $Departments %>
        <div class="topic-browse-by-filter__grid topic-browse-by-filter__grid--full">
          <div class="topic-browse-by-filter__item">
            <h2 id="browse-categories" class="topicholder-section__heading">Browse by...</h2>
          </div>
        </div>
        <div class="topic-browse-by-filter__grid"  data-equalizer>
        <% loop $Categories.Sort('Title ASC') %>
            <div class="topic-browse-by-filter__item topic-browse-by-filter__item--small margin-bottom-1" data-equalizer-watch><a href="$Link" class="button hollow secondary button--flex-full button--skinny"><span class="topicholder-cat-inner" style="<% if $JobListings %>font-weight: bold;<% end_if %>">$Title&nbsp;<span style="topicholder-cat-inner__count">({$ActiveJobListings})</span></span></a></div>
        <% end_loop %>
        <% loop $Departments.Sort('Title ASC') %>
            <div class="topic-browse-by-filter__item topic-browse-by-filter__item-small margin-bottom-1" data-equalizer-watch><a href="$Link" class="button hollow secondary button--flex-full button--skinny"><span class="topicholder-cat-inner">$Title&nbsp;<span style="topicholder-cat-inner__count">({$ActiveJobListings})</span></span></a></div>
          <% end_loop %>
        </div>
      <% end_if %>




</div>
