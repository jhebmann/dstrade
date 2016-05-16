<script src="/js/jquery-1.12.3.min.js"></script>
<button id="btn-menu"></button>
<div id="menu">
    <ul>
        <li>
            <a href="/">Homepage</a>
        </li>
        <?php
        if ($connected) { ?>
            <li>
                <a href="/profile/infos">profile</a>
            </li>
            <li>
                <a href="/trade/new">Trade</a>
            </li>
            <li>
                <a href="/buy">Buy souls</a>
            </li>
            <li>
                <a href="/vip">VIP</a>
            </li>
            <li>
                <a href="/market">Market</a>
            </li>
            <li>
                <a href="/trade/browse">Trade Offers</a>
            </li>
            <?php
            if ($user_infos['role'] == "ADMIN") {
                ?>
                <li>
                    <a href="/trade/accepted">Accepted Offers</a>
                </li>
                <?php
            }
            ?>
            <li>
                <a href="/logout">Log Out</a>
            </li>
            <?php
        } else { ?>
            <li>
                <a href="/login">LOGIN</a>
            </li>
            <li>
                <a href="/register">Register</a>
            </li>
            <?php
        }
        ?>
    </ul>
</div>
<script>
    $(window).resize(function () {
        if ($("html").width() > 1000) {
            $("#menu").show();
        }
    });

    $("#btn-menu").click(function () {
        $("#menu").slideToggle();
    });
</script>