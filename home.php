<?php 
include 'admin/db_connect.php'; 
?>
<style>
.event-list-container {
    overflow: hidden;
    margin-top: 20px;
    height: 400px; /* Fix size of the container */
    transition: height 0.5s; /* Add transition for smooth resizing */
}

.event-list {
    animation: slide-up 10s linear infinite;
}

@keyframes slide-up {
    0% {
        transform: translateY(0%);
    }
    100% {
        transform: translateY(-100%);
    }
}
.event-list-wrapper {
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 0.5s;
}

@keyframes slide-up {
    from {
        transform: translateY(0);
    }
    to {
        transform: translateY(-100%);
    }
}

.event-list-container {
    overflow: hidden;
    height: auto;
}

.event-list-wrapper {
    animation: slide-up 10s linear infinite;
}

</style>
<?php if(isset($_SESSION['login_id'])): ?>
    <header class="masthead">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <div style="display: flex; justify-content: center; align-items: center; height: 35vh;">
                    <img src="http://localhost/project3/alumni/img/111.jpeg" alt="Your Image Description" style="max-height: 100%;">
                </div>
                <div class="col-md-12 mb-2 justify-content-center"></div>
                <h3 class="text-white">Welcome to <?php echo $_SESSION['system']['name']; ?></h3>
                <hr class="divider my-4" />
                <div class="col-md-12 mb-2 justify-content-center"></div>
            </div>
        </div>
    </header>
    <?php
    $event = $conn->query("SELECT * FROM events where date_format(schedule,'%Y-%m%-d') >= '".date('Y-m-d')."' order by unix_timestamp(schedule) asc");
    $event_count = $event->num_rows;
    ?>
    <?php if($event_count > 0): ?> <!-- Check if there are events -->
        <h4 class="text-center text-white">Upcoming Events</h4>
        <hr class="divider">
        <div class="container mt-3 pt-2 event-list-container" id="eventListContainer">
            <?php
            while($row = $event->fetch_assoc()):
                $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
                unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                $desc = strtr(html_entity_decode($row['content']),$trans);
                $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
            ?>
            <div class="card event-list" data-id="<?php echo $row['id'] ?>">
                <div class='banner'>
                    <?php if(!empty($row['banner'])): ?>
                        <img src="admin/assets/uploads/<?php echo($row['banner']) ?>" alt="">
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="row align-items-right justify-content-center text-center h-100 w-40">
                        <div class="text-center event-details">
                            <h3><b class="filter-txt"><?php echo ucwords($row['title']) ?></b></h3>
                            <div><small><p><b><i class="fa fa-calendar"></i> <?php echo date("F d, Y h:i A",strtotime($row['schedule'])) ?></b></p></small></div>
                            <hr>
                            <larger class="truncate filter-txt"><?php echo strip_tags($desc) ?></larger>
                            <br>
                            <hr class="divider"  style="max-width: calc(80%)">
                            <button class="btn btn-primary float-right read_more" data-id="<?php echo $row['id'] ?>">Read More</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="container mt-3 pt-2 event-list-container" id="eventListContainer" style="display: none;"></div> <!-- Hide the container if no events -->
    <?php endif; ?>
<?php else: ?>
    <header class="masthead">
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end mb-4 page-title">
                    <div style="display: flex; justify-content: center; align-items: center; height: 35vh;">
                        <img src="http://localhost/project3/alumni/img/111.jpeg" alt="Your Image Description" style="max-height: 100%;">
                    </div>
                    <div class="col-md-12 mb-2 justify-content-center"></div>
                    <h3 class="text-white">Welcome to <?php echo $_SESSION['system']['name']; ?></h3>
                    <hr class="divider my-4" />
                    <div class="col-md-12 mb-2 justify-content-center"></div>
                </div>
            </div>
        </div>
    </header>
<?php endif; ?>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var eventCards = document.querySelectorAll('.event-list');
    var eventListContainer = document.getElementById('eventListContainer');

    eventCards.forEach(function (card) {
        card.addEventListener('mouseenter', function () {
            card.style.animationPlayState = 'paused'; // Pause animation on mouseenter
            eventCards.forEach(function (otherCard) {
                if (otherCard !== card) {
                    otherCard.style.animationPlayState = 'paused'; // Pause other cards' animations
                }
            });
        });

        card.addEventListener('mouseleave', function () {
            card.style.animationPlayState = 'running'; // Resume animation on mouseleave
            eventCards.forEach(function (otherCard) {
                if (otherCard !== card) {
                    otherCard.style.animationPlayState = 'running'; // Resume other cards' animations
                }
            });
        });
    });
});
$('.read_more').click(function(){
         location.href = "index.php?page=view_event&id="+$(this).attr('data-id')
     })
</script>
