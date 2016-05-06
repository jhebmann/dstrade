<?php
include('connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>DSTrade</title>
</head>
<body>
<div class="question">
    <p>What is DSTrade ?</p>
</div>
<div class="answer">
    <p>DSTrade is a website which wants to improve your overall Dark Souls experience by allowing you to buy or exchange
        items !</p>
</div>
<div class="question">
    <p>How does it work ?</p>
</div>
<div class="answer">
    <p>It's fairly simple. First things first, you'll have to create an account <a href="register">Here</a> and <a
            href="login">log in</a>. Then, you have 3 options to get the items you want.</p>
    <ul>
        <li>Buy some souls <a href="buy">Here</a> and then go to the market <a href="market">Here</a> and buy your item
            with your souls !
        </li>
        <li>Declare having some items on your profile (<a href="profile/myitems/add">Here</a>) and make a trade offer <a
                href="offers/add">Here</a> so others can see it.
        </li>
        <li>Of course, you can also browse existing trade offers <a href="offers/search">Here</a> to see if someone is
            selling what you want !
        </li>
    </ul>
</div>
<div class="question">
    <p>Wait a minute ... Dark Souls doesn't have a trade system, right ? So how can I be sure I won't be scammed by the
        other guy when I'll drop my item on the floor ?</p>
</div>
<div class="answer">
    <p>Don't worry, we thought about this ! After validating a trade offer with another user, a member of our staff will
        put down his mark so you can summon him in your world. He'll wait for you to drop your(s) item(s), and then do
        the same in the world of the other trader.</p>
    <p>If items are correctly given to him, he'll then give you the item you wanted, and do the same for the other
        trader.</p>
    <p>And if they're not the right item, he'll give you your item back !</p>
    <p>If you buy an item from our shop, you'll just have to summon our staff member so he can give you the item you
        wanted !</p>
</div>
<div class="question">
    <p>Dark Souls summon system is really bad ... How can I be sure I will be able to summon your staff member ?</p>
</div>
<div class="answer">
    <p>We thought about that ;) We're using <a href="http://www.nexusmods.com/darksouls/mods/1047"
                                               target=_blank>This</a> mod to improve Dark Souls connectivity.</p>
    <p>For it to work, however, we'll need your Steam64 ID</p>
</div>
<div class="question">
    <p>What is this "Steam64 ID" you want me to fill on my profile ?</p>
</div>
<div class="answer">
    <p>Steam64 ID is not compulsory, but helps a lot in being able to summon our staff member so he can proceed trades
        and deliver items.</p>
    <p>It is used to ensure you'll see our mark to summon us. Don't worry, it's not a sensible information like your
        steam login or password (we'll NEVER ask you for them).</p>
    <p>You can find your Steam64 ID by following these steps :</p>
    <ul>
        <li>Go to your Steam profile, right clic and select "Copy Page URL"</li>
        <li>Then, go to <a href="http://steamid.io">steamid.io</a> and paste the URL into the input field</li>
        <li>Copy the resulting Steam64 ID from the results</li>
        <li>Go to <a href="profile">your profile</a>, paste your Steam64 ID in the corresponding field, and save
            modifications.
        </li>
    </ul>
</div>
<div class="question">
    <p>How can you be summoned in any world ? There are level restrictions !</p>
</div>
<div class="answer">
    <p>That's true, you can't summon a lvl 700 player if you're lvl 1. But we've got several accounts with characters in
        all lvl ranges, so we can give you the item you bought no matter how high/low your lvl is.</p>
    <p>And since we have several accounts, we can also proceed trades between players that have a great lvl difference
        !</p>
</div>
</body>
</html>