
<article class="topic-card <% if $Last %>topic-card--no-border<% end_if %> clearfix">
	<% if $FeaturedImage %>
		<a href="$Link" class="topic-card__img">
			<img class="dp-lazy" data-original="$FeaturedImage.FocusFill(500,333).URL" width="500" height="333" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="$Title">
		</a>
	<% end_if %>
	<div class="topic-card__content<% if $FeaturedImage || $BackgroundImage || $YoutubeBackgroundEmbed %>--wimage<% end_if %>">

		<h3 class="topic-card__heading topic-card__heading--lighter">
            <a href="$Link" style="color: #005994;">$Title</a>
        </h3>



    		<p class="blogcard__desc"><strong>Location:</strong> $Location<br /><strong>Basic Job Function: </strong>$BasicJobFunction.LimitCharacters(150) <a href="$Link">Continue reading</a></p>




        <% if $NextStepLink %>
        <p><a href="$NextStepLink" target="_blank" class="button small">Apply for this job <i class="fa fa-external-link" aria-hidden="true"></i></a></p>
        <% else %>
        <p><strong>Status: </strong>Not currently hiring</p>
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
