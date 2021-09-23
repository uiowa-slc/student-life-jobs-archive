$Header
<main class="main-content__container" id="main-content__container">

    <% if $BackgroundImage %>
        <% include FeaturedImage %>
    <% end_if %>

    <%-- <p><a href="{$Parent.Link}"><i class="fa fa-chevron-left" aria-hidden="true"></i> <span>Browse all job listings</span></a></p> --%>
    <% if not $BackgroundImage %>
        <div class="column row">
            <div class="main-content__header">
                $Breadcrumbs
                <h1>$Title</h1>
            </div>
        </div>
    <% end_if %>

    $BlockArea(BeforeContent)

    <div class="row column">

        <article role="main" class="main-content main-content--with-padding <% if $Children || $Menu(2) || $SidebarBlocks ||  $SidebarView.Widgets %>main-content--with-sidebar<% else %>main-content--full-width<% end_if %>">
            $BlockArea(BeforeContentConstrained)
            <div class="main-content__text">

            <div class="content">
                <div class="blogmeta">

                    <% loop $Departments.Limit(1) %><a href="$Link" class="topic-single__byline-cat">$Title</a><% end_loop %>
                    <ul class="social-icons">
                        <li><span>Share:</span></li>
                        <li><a href="javascript:window.open('http://www.facebook.com/sharer/sharer.php?u=$AbsoluteLink', '_blank', 'width=400,height=500');void(0);"  title="Share on Facebook"><img src="{$ThemeDir}/dist/images/icon_facebook.png" alt="Share on Facebook"></a>
                        </li>
                        <li><a href="https://twitter.com/intent/tweet?text=$AbsoluteLink" title="Share on Twitter" target="_blank"><img src="{$ThemeDir}/dist/images/icon_twitter.png" alt="Share on Twitter"></a></li>
                        <li><a href="javascript:window.open('https://www.linkedin.com/cws/share?url=$AbsoluteLink', '_blank', 'width=400,height=500');void(0);" title="Share on LinkedIn" target="_blank"><img src="{$ThemeDir}/dist/images/icon_linkedin.png" alt="share on linkedid"></a></li>
                    </ul>
                </div>
                <div class="job-single__basic-info">

                <% if $PayRate %><p><span class="job-single__descriptor">Rate of pay:</span> $PayRate</p><% end_if %>
                <% if $Location %><p><span class="job-single__descriptor">Work location:</span> <% if $WorkLocation %>{$WorkLocation}, <% end_if %><a href="$Location.Link">$Location.Title</a></p><% end_if %>
                <% if $Department %><p><span class="job-single__descriptor">Department:</span> <a href="$Department.Link">$Department.Title</a></p><% end_if %>
                <p><span class="job-single__descriptor">Status:</span> <% if $Active %><span class="text-green font-weight-bold">Currently hiring</span><% else %><span class="text-red font-weight-bold">Not currently hiring</span><% end_if %></span></p>
                <% if $Active && $NextStepLink %>

                <% if $AcceptsNonHawkIdApplicants %>
                <p>
                    <a href="$NextStepLink" class="button" target="_blank">Apply for this job <strong>(UI Students)</strong> <i class="fa fa-external-link-alt" aria-hidden="true"></i></a>
                    <a href="$JobFeedBase" class="button" target="_blank">Not a UI Student? <strong>Apply for this job here</strong> <i class="fa fa-external-link-alt" aria-hidden="true"></i></a>

                <% else %>
                    <p><a href="$NextStepLink" target="_blank" rel="noopener" class="button">Apply for this job <i class="fa fa-external-link-alt" aria-hidden="true"></i></a></p>
                <% end_if %>

                <% if $TrainingRequirements || $Qualifications %>
                    <p style="font-size: 16px;">Before applying for this job, please check the <% if $Qualifications %><a href="{$Link}#qualifications">qualifications</a> <% end_if %><% if $TrainingRequirements && $Qualifications %>and <% end_if %><% if $TrainingRequirements %><a href="{$Link}#training-requirements">training requirements</a> <% end_if %>for this position.</p>
                <% end_if %>
                <% end_if %>

                </div>
                    <% if $LearningOutcomes %>

                        <h2>What you will learn</h2>
                        $LearningOutcomes

                <% end_if %>
                <% if $BasicJobFunction %>

                        <h2>Basic job function</h2>
                        $BasicJobFunction

                <% end_if %>

                <% if $Responsibilities %>

                        <h2>Responsibilities</h2>
                        $Responsibilities

                    <% end_if %>


                <% if $WorkHours %>

                        <h2>Work hours</h2>
                        $WorkHours

                <% end_if %>
                <% if $Qualifications %>

                        <h2 id="qualifications">Qualifications</h2>
                        $Qualifications

                <% end_if %>
                <% if $TrainingRequirements %>

                        <h2 id="training-requirements">Training requirements</h2>
                        $TrainingRequirements

                <% end_if %>
                <% if $NextStepLink %>
                    <div class="apply__container">

                        <% if $AcceptsNonHawkIdApplicants %>
                            <a href="$NextStepLink" class="button" target="_blank">Apply for this job <strong>(UI Students)</strong> <i class="fa fa-external-link-alt" aria-hidden="true"></i></a>
                            <a href="$JobFeedBase" class="button" target="_blank">Not a UI Student? <strong>Apply for this job here</strong><i class="fa fa-external-link-alt" aria-hidden="true"></i></a>
                        <% else %>
                            <a href="$NextStepLink" class="button apply__button" target="_blank">Apply for this job  <i class="fa fa-external-link-alt" aria-hidden="true"></i></a>
                        <% end_if %>

                        <div class="apply__content">
                            <% if $Content %>
                            $Content
                            <% else_if $NextStepDomain == "hireahawk.com" %>
                            <p><a href="work-on-campus/hire-a-hawk/">Learn more about how to apply for a job through Hire-A-Hawk with these instructions.</a></p>
                            <% end_if %>
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

            <%-- <% include JobListingRelated %> --%>
            <hr />
            <h2>More job listings:</h2>

            <% with $Parent %>
             <% include JobBrowseByFilterFull %>
            <% end_with %>
            <%-- <% include JobListingStatement %> --%>
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
