$Header
<main class="main-content__container" id="main-content__container">

	<!-- Background Image Feature -->
	<% if $BackgroundImage %>
		<% include FeaturedImage %>
	<% end_if %>
	$Breadcrumbs

	<% if not $BackgroundImage %>
		<div class="column row">
			<div class="main-content__header">
				<h1>$Title</h1>
			</div>
		</div>
	<% end_if %>

	$BlockArea(BeforeContent)

	<div class="row">

		<article role="main" class="main-content main-content--with-padding <% if $Children || $Menu(2) || $SidebarBlocks ||  $SidebarView.Widgets %>main-content--with-sidebar<% else %>main-content--full-width<% end_if %>">
			$BlockArea(BeforeContentConstrained)
			<div class="main-content__text">
				<div class="job-single__basic-info">
				<% if $PayRate %><p><span class="job-single__descriptor">Rate of pay:</span> $PayRate</p><% end_if %>
				<% if $Location %><p><span class="job-single__descriptor">Location:</span> $Location</p><% end_if %>
				</div>
			
				<% if $BasicJobFunction %>
		
						<h2>Basic job function</h2>
						$BasicJobFunction

				<% end_if %>
				<% if $LearningOutcomes %>
			
						<h2>What you will learn</h2>
						$LearningOutcomes
		
				<% end_if %>
		
				<% if $NextStepLink %>
					<div class="apply__container">
						<a href="$NextStepLink" class="button apply__button"><% if $NextStepTitle %>$NextStepTitle<% else %>Next step<% end_if %></a>
						<div class="apply__content">
							$Content
						</div>
					</div>
				<% end_if %>
				<% if $Links %>
					<h2>Additional information:</h2>
					<ul>
					<% loop $Links %>
						<li><a href="$URL" target="_blank"><% if $Title %>$Title<% else %>$URL.LimitCharacters(50)<% end_if %></a></li>
					<% end_loop %>
					</ul>
				<% end_if %>
			</div>
			<% include TagsCategories %>
			<% include JobListingHolderFeaturedTopics %>
			<% include JobListingStatement %>
			$BlockArea(AfterContentConstrained)
			$Form

		</article>
		<aside class="sidebar dp-sticky">
			<% include SideNav %>
			<% if $SideBarView %>
				$SideBarView
			<% end_if %>
			$BlockArea(Sidebar)
		</aside>
	</div>
	$BlockArea(AfterContent)

</main>