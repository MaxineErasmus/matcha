<div class="well">
    <div class="row">
        <div class="col-lg-2 col-sm-2 col-xs-4">
            <div class="button-group">
                <img src="../images/icons/015-binoculars.svg" class="icon center-block">
                <a href="../dir/browse.php"><button class="btn-danger maroon">Browse</button></a>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-xs-4">
            <div class="button-group">
                <img src="../images/icons/018-envelope-blue.svg" class="icon center-block">
                <a id="sumAllUnreadMsgs" href="../dir/chat.php">
                    <button class="btn-danger maroon">Chat <span id="sumAllUnreadChatMsgs" class='badge'>0</span></button>
                </a>
                <script type="text/javascript">getSumAllUnreadMsgsAJAX();</script>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-xs-4">
            <div class="button-group">
                <img src="../images/icons/010-feather.svg" class="icon center-block">
                <a href="../dir/news.php">
                    <button class="btn-danger maroon">News <span id="sumNotifications" class='badge'>0</span></button>
                </a>
                <script type="text/javascript">getSumNotificationsAJAX();</script>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-xs-4">
            <div class="button-group">
                <img src="../images/icons/008-user-male-black-shape.svg" class="icon center-block">
                <a href="../dir/profile.php"><button class="btn-danger maroon">Profile</button></a>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2"></div>
        <div class="col-lg-2 col-sm-2 col-xs-4">
            <div class="button-group">
                <img src="../images/icons/009-taxi.svg" class="icon center-block">
                <a href="../lib/logout.php"><button class="btn-info blue">Exit</button></a>
            </div>
        </div>
    </div>
</div>