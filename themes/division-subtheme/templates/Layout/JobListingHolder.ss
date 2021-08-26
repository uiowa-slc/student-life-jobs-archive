$Header
<main class="main-content__container" id="main-content__container">

<% if $Action == "index" %>
    <% with $BackgroundImage %>
      <div style="background-repeat: no-repeat; background-size: cover;" data-interchange="[$FocusFill(600,400).URL, small], [$FocusFill(1600,500).URL, medium]">
    <% end_with %>
    <div class="topic-search-bg background-image" style="background-position: {$PercentageX}% {$PercentageY}%;">
        <div class="topic-search-container">
          <h1 class="background-image__title" style="margin-bottom: 20px;"><a href="$Link" class="hero__header hero__header--white hero__header--large">$Title</a></h1>
          $TopicSearchFormSized

          <% if $Categories(true) %>
          <p class="topic-search-minicats">
            <span class="topic-search-minicats__heading">Browse currently hiring jobs by category:</span>
            <% loop $Categories(true).Sort('Title') %>
            <span class="topic-search-minicats__cat"><a href="$Link">$Title ({$ActiveJobListings})</a><% if not $Last %>,</span><% end_if %>
            <% end_loop %>
            </p>
            <% end_if %>
        </div>
    </div>
  </div>
<% else_if $FilterType %>

  <div class="grid-container">
    <div class="grid-x align-center grid-padding-x">
      <div class="cell">
        <div class="main-content__header">
            $Breadcrumbs
              <h1>{$FilterTitle}</h1>

        </div>
      </div>
    </div>
  </div>

<% end_if %>

$BeforeContent

<%-- if we aren't filtering, eg, the main/home view, show the bubble filters --%>
<% if not $FilterType %>
  <% if $Content %>
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
          <article class="cell medium-8 large-

          6 medium-centered">
            $BeforeContentConstrained


            <div class="topic-content main-content__text">
              $Content

            </div>


          </article>

      </div>
    </div>
  <% end_if %><%-- end if content --%>
    <div class="grid-container grid-container--wpadding">
        <div class="grid-x grid-padding-x">
          <div class="cell large-12">
              <% include JobBrowseByFilterFull %>
          </div>
        </div>
    </div>
<%-- if we are filtering by something: --%>
<% else_if $FilterType %>

<div class="grid-container">

  <div class="grid-x grid-padding-x">
    <div class="cell small-12 large-1 show-for-large"></div>
    <article class="cell medium-10">

      $BeforeContentConstrained


        <% if $FilterType %>

                <% if $FilterOpenClosed == "all" %>

                    <% include JobFilterContent_all %>
                <% else %>
                    <% include JobFilterContent %>
                <% end_if %>



        <% end_if %>



    </article>
      <div class="cell small-12 large-1 show-for-large">

      </div>

      <div class="cell large-10 large-centered">
        <div class="dp-sticky dp-sticky--medium">
          <div style="padding-top: 20px;">
            $TopicSearchFormSized("small")
            <% include JobBrowseByFilterFull %>
          </div>
      </div>
    </div>


  </div>


</div>


<% end_if %>


  <%--<% include JobFooterFull %> --%>

    $AfterContentConstrained
    $Form



$AfterContent

</main>
