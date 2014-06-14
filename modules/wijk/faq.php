<?php


doc(
    "wijk",
    "FAQ <span class='label label-warning'>Zal wel</span>",
    "GET <code>/faq?district=1</code>",
    "<h4>Return:</h4>
    <pre><b>Wat is glasvezel?</b><p>heel tekstje</p></pre>");
$app->get("/faq", function(){
    ?>
    <b>Wat is glas?</b>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquam animi consequuntur dolor eius eos error excepturi, explicabo in laboriosam maxime, minima minus quam qui recusandae rem, ullam veniam voluptates!</p>
    <b>Wat is vezel?</b>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquam animi consequuntur dolor eius eos error excepturi, explicabo in laboriosam maxime, minima minus quam qui recusandae rem, ullam veniam voluptates!</p>
    <b>Wat is glasvezel?</b>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquam animi consequuntur dolor eius eos error excepturi, explicabo in laboriosam maxime, minima minus quam qui recusandae rem, ullam veniam voluptates!</p>
<?php
});
