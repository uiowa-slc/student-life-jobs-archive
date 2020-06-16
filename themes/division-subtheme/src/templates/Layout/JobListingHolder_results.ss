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
    <div class="cell small-12 large-1 show-for-medium"></div>
      <article class="cell medium-8 large-6">
          <div style="padding-top: 20px;">
            $TopicSearchFormSized("medium")
          </div>
        $BeforeContentConstrained

        <% if $Results %>
          <% loop $Results %>
              <% include JobCard %>
          <% end_loop %>

        <% else %>
              <% if $Query %>
                <p style="margin-top: 20px; font-weight: bold;">Sorry, there are no open jobs that matched this search term.</p>
              <% else %>
                <p style="margin-top: 20px; font-weight: bold;">No search term specified. Please specify a search term and try searching again.</p>
              <% end_if %>

        <% end_if %>

<%--         <% include JobFeedback %> --%>

      </article>

      <div class="cell small-12 large-1 show-for-large">

      </div>

      <div class="cell medium-4">
        <div class="dp-sticky dp-sticky--medium">



          <% include JobBrowseByFilter %>
        </div>
      </div>
  </div>
</div>

<%--   <% include JobFooterFull %>
 --%>
    $AfterContentConstrained
    $Form



$AfterContent

</main>
