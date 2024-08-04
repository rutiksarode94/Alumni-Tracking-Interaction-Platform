<?php 
include 'admin/db_connect.php';
session_start(); // Start the session
?>
<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM events where id= ".$_GET['id']);
    foreach($qry->fetch_array() as $k => $val){
        $$k=$val;
    }
    $commits = $conn->query("SELECT * FROM event_commits where event_id = $id");
    $cids= array();
    while($row = $commits->fetch_assoc()){
        $cids[] = $row['user_id'];
    }
}
?>
<style type="text/css">
    #portfolio .img-fluid{
    width: calc(100%);
    height: 30vh;
    z-index: -1;
    position: relative;
    padding: 1em;
}
.event-list{
cursor: pointer;
}
span.hightlight{
    background: yellow;
}
.banner{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 26vh;
        width: calc(30%);
    }
    .banner img{
        width: calc(100%);
        height: calc(100%);
        cursor :pointer;
    }
.event-list{
cursor: pointer;
border: unset;
flex-direction: inherit;
}

.event-list .banner {
    width: calc(40%)
}
.event-list .card-body {
    width: calc(60%)
}
.event-list .banner img {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    min-height: 50vh;
}
span.hightlight{
    background: yellow;
}
.banner{
   min-height: calc(100%)
}
</style>
<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Events</h3>
                <hr class="divider my-4" />
                <!-- Additional Admin-specific buttons can be added here -->
            </div>
        </div>
    </div>
</header>
<section></section>
<div class="container">
    <div class="col-lg-12">
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        
                    </div>
                    <div class="col-md-12" id="content">
                    <p class="">
                        
                        <p><b><i class="fa fa-calendar"></i> <?php echo date("F d, Y h:i A",strtotime($schedule)) ?></b></p>
                        <?php echo html_entity_decode($content); ?>
                    </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr class="divider" style="max-width: calc(100%);"/>
                        <div class="text-center">
                            <?php if(isset($_SESSION['login_id'])): ?>
                                <?php if(in_array($_SESSION['login_id'], $cids)): ?>
                                    <span class="badge badge-primary">Commited to Participate</span>
                                <?php else: ?>
                                    <button class="btn btn-primary" id="participate" type="button">Participate</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-primary">Login to Participate</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#imagesCarousel img,#banner img').click(function(){
        viewer_modal($(this).attr('src'))
    })
    $('#participate').click(function(){
        _conf("Are you sure to commit that you will participate to this event?","participate",[<?php echo $id ?>],'mid-large')
    })

    function participate($id){
        start_load()
        $.ajax({
            url:'admin/ajax.php?action=participate',
            method:'POST',
            data:{event_id:$id},
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully recorded",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)

                }
            }
        })
    }
</script>
