<div class="row">
    <div class="col-lg-1 col-sm-1"></div>
    <button id="filter_btn" class="btn-default btn-md col-lg-1 col-sm-1 col-xs-2" onclick="showFilterMenu()"><img src="../images/icons/020-menu.svg"></button>
    <div class="col-lg-9 col-sm-9 col-xs-10">
        <form action="#" method="post">
            <div class="row">
                <input id="search_interests" name="search_interests" title="Enter search #interests here..." placeholder="#fun #art ..." type="text" autocomplete="text" class="well col-lg-10 col-sm-10 col-xs-8">
                <input id="search_submit" name="search_submit" type="submit" value="Search" class="btn-default btn-md col-lg-2 col-sm-2 col-xs-4">
            </div>
            
            <div class="row text-left" id="filter_menu" style="display: none">
                <div class="filter_menu col-lg-10 col-sm-10 col-xs-8">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                            <label>Min Age :</label>
                            <input id="min_age" name="search_min_age" type="number" title="Min Age" name="min_age" min="18" max="200" autocomplete="number">
                        </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                            <label>Max Age :</label>
                            <input id="max_age" name="search_max_age" type="number" title="Max Age" name="max_age" min="18" max="200" autocomplete="number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                            <label>Min Fame :</label>
                            <input id="min_fame" name="search_min_fame" type="number" title="Min Fame" name="min_fame" min="0" autocomplete="number">
                        </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                            <label>Max Fame :</label>
                            <input id="max_fame" name="search_max_fame" type="number" title="Max Fame" name="max_fame" min="0" autocomplete="number">
                        </div>
                    </div>
                </div>
                <div col-lg-2 col-sm-2 col-xs-4></div>
            </div>
        </form>
    </div>
    <div class="col-lg-1 col-sm-1"></div>
</div>