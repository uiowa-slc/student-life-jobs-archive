<header class="masthead">
	<amp-img src="https://vp.studentlife.uiowa.edu/themes/division-subtheme/dist/images/uiowa.png" width="195" height="24" class="masthead-img"></amp-img>
	<a class="title" href="$AbsoluteBaseURL" target="_blank">$SiteConfig.Title</a>
</header>
<main role="main">
	<article>
		<header>
			<h1 class="headline">$Title</h1>
			<% if $FeaturedImage %>
				<amp-img src="$FeaturedImage.CroppedFocusedImage(1024,682).URL" width="1024" height="682" layout="responsive"></amp-img></p>
			<% end_if %>
		</header>

		<div class="main-column">
			<p>
				<amp-social-share type="facebook" width="40" height="40" data-param-app_id="127918570561161" class="social-share"></amp-social-share>
				<amp-social-share type="twitter" width="40" height="40" class="social-share"></amp-social-share>
				<amp-social-share type="linkedin" width="40" height="40" class="social-share"></amp-social-share>
				<amp-social-share type="email" width="40" height="40" class="social-share"></amp-social-share>
			</p>

			
				<div class="blogmeta clearfix">
					<div class="blogmeta__byline clearfix">
					<p>
						Department(s): <% loop $Departments.Limit(1) %><a href="$Link" class="topic-single__byline-cat">$Title</a><% end_loop %>
					</p>
					</div>

				</div>
				<div class="job-single__basic-info">
				<% if $PayRate %><p><span class="job-single__descriptor">Rate of pay:</span> $PayRate</p><% end_if %>
				<% if $Location %><p><span class="job-single__descriptor">Work location:</span> $Location</p><% end_if %>
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
						<a href="$NextStepLink" class="button apply__button" target="_blank"><% if $NextStepTitle %>$NextStepTitle<% else %>Next step<% end_if %></a>
						<div class="apply__content">
							<% if $Content %>
							$Content
							<% else_if $NextStepDomain == "hireahawk.com" %>
							<p><a href="work-on-campus/hire-a-hawk/">Learn more about how to apply for a job through Hire-A-Hawk with these instructions.</a></p>
							<% end_if %>
						</div>
					</div>
					<hr />
					<p>Jobs listed on this website do not reflect current openings. To view availability and apply for this position, <a href="$NextStepLink" target="_blank">visit this website</a>.</p>
				<% end_if %>
			
				<% if $Links %>
					<h2>Additional information:</h2>
					<ul>
					<% loop $Links %>
						<li><a href="$URL" target="_blank"><% if $Title %>$Title<% else %>$URL.LimitCharacters(50)<% end_if %></a></li>
					<% end_loop %>
					</ul>
				<% end_if %>
				<% include JobListingDeptsCategories %>

			

			<hr />
			<p class="text-center"><a href="{$AbsoluteBaseURL}/jobs" class="button">See more jobs on campus</a></p>

		</div>
	</article>
	<% include AmpFooter %>
</main>