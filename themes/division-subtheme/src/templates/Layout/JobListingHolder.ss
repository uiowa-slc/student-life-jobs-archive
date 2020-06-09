$Header
<main class="main-content__container" id="main-content__container">


<% if $Action == "index" %>
<%--   <% include FeaturedImage %> --%>
<% with $BackgroundImage %>
  <div style="background-repeat: no-repeat; background-size: cover;" data-interchange="[$FocusFill(600,400).URL, small], [$FocusFill(1600,500).URL, medium]">
<% end_with %>
    <div class="topic-search-bg background-image" style="background-position: {$PercentageX}% {$PercentageY}%;  display: flex;
    align-items: center; background: rgba(0,0,0,0.4);">


        <div style="max-width: 700px; margin: auto; text-align: center; z-index:1; position: relative;">
          <h1 class="background-image__title" style="margin-bottom: 20px;"><a href="$Link" style="color: white;">$Title</a></h1>
          $TopicSearchFormSized

          <p style="color: white; font-size: 16px; line-height: 2">
            <span class="topic-search-minicats__heading">Browse open positions by category:</span>
            <% loop $Categories.Sort('Title') %>
            <span style="display: inline-block; margin: 0 2px; "><a href="$Link" style="color: white; text-decoration: underline;">$Title</a><% if not $Last %>,</span><% end_if %>
            <% end_loop %>

<%--             <% if $Categories.Count > 20 %>
              <span class="topic-search-minicats__heading"><a href="#browse-categories" style="color: white; text-decoration: underline;">and more...</a></span>
            <% end_if %> --%>

            </p>
        </div>


    </div>
  </div>
<% else_if $FilterType %>
   $Breadcrumbs
  <div class="grid-container">
    <div class="grid-x align-center grid-padding-x">
      <div class="cell">
        <div class="main-content__header">
        <% if $FilterType.Content || $CurrentTag.Content %>
          <% if $FilterType %>
            <h1>$FilterType.Title</h1>
          <% end_if %>
        <% else %>
          <% if $FilterType %>
              <h1>Jobs listed under &ldquo;{$FilterTitle}&rdquo;: </h1>
          <% end_if %>
        <% end_if %>
        </div>
      </div>
    </div>
  </div>

<% end_if %>

$BeforeContent


<% if not $FilterType %>
  <% if $Content %>
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
          <article class="cell medium-8 large-

          6">
            $BeforeContentConstrained


            <div class="topic-content main-content__text">
              $Content

            </div>


          </article>

          <div class="cell medium-4">
            <div class="dp-sticky dp-sticky--medium">
              <% include JobBrowseByFilter %>
            </div>
        </div>
      </div>
    </div>
  <% else %>
    <div class="grid-container grid-container--wpadding">
        <div class="grid-x grid-padding-x">
          <div class="cell large-12">
              <% include JobBrowseByFilterFull %>
          </div>
        </div>
    </div>
  <% end_if %><%-- end if content --%>

<% else_if $FilterType %>

<div class="grid-container">

  <div class="grid-x grid-padding-x">
    <div class="cell small-12 large-1 show-for-large"></div>
    <article class="cell medium-8 large-6">

      $BeforeContentConstrained


        <% if $FilterType %>

            <% include JobFilterContent %>

        <% end_if %>


    </article>
<%--       <div class="cell small-12 large-1 show-for-large">

      </div>

      <div class="cell medium-4">
        <div class="dp-sticky dp-sticky--medium">
          <div style="padding-top: 20px;">
            $TopicSearchFormSized("small")
            <% include JobBrowseByFilter %>
          </div>
      </div>
    </div> --%>


  </div>
</div>

<% end_if %>
<%--

  <% include JobBrowseAllFull %>
  <% include JobFooterFull %>

    $AfterContentConstrained
    $Form



$AfterContent --%>

</main>
