<article class="topic-card topic-card--no-border clearfix">
	<% if $FeaturedImage %>
		<a href="$Link" class="topic-card__img">
			<img class="dp-lazy" data-original="$FeaturedImage.FocusFill(500,333).URL" width="500" height="333" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="$Title">
		</a>
	<% end_if %>
	<div class="topic-card__content<% if $FeaturedImage || $BackgroundImage || $YoutubeBackgroundEmbed %>--wimage<% end_if %>">
		<h3 class="topic-card__heading">
            <a href="$Link">$Title</a>
        </h3>
		<p class="blogcard__desc"><strong>Location:</strong> <% if $WorkLocation %>{$WorkLocation}, <% end_if %> $Location.Title<br /><strong>Basic Job Function: </strong>$BasicJobFunction.LimitCharacters(150) <a href="$Link">Continue reading</a><br />


        <strong>Status: </strong><% if $Active %><span class="text-green font-weight-bold">Currently hiring</span><% else %><span class="text-red font-weight-bold">Not currently hiring</span><% end_if %>
        </p>
        <% if $Active %>
            <p><a href="$Link" class="button small">Learn more</a>
                <% if $AcceptsNonHawkIdApplicants %>

                    <a href="$NextStepLink" class="button small" target="_blank">Apply for this job <strong>(UI Students)</strong> <i class="fa fa-external-link-alt" aria-hidden="true"></i></a>
                    <a href="$JobFeedBase" class="button small" target="_blank">Not a UI Student? <strong>Apply for this job here</strong> <i class="fa fa-external-link-alt" aria-hidden="true"></i></a>
                <% else %>
                   <a href="$NextStepLink" target="_blank" rel="noopener" class="button small">Apply for this job <i class="fa fa-external-link-alt" aria-hidden="true"></i></a>
                <% end_if %>
            </p>
        <% else %>

        <% end_if %>
        <% if $Categories.exists %>
            <p class="topic-card__category">
                <% loop $Categories %>
                    <a href="$Link" class="button hollow tiny secondary" style="border-radius: 4px; margin-bottom: 4px;">$Title</a>
                <% end_loop %>
            </p>
        <% end_if %>
	</div>
</article>
