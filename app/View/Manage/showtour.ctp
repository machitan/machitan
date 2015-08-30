<div class="container">
    <div class="jumbotron">
      <h4><i class="mdi-action-explore"></i> ツアーをえらんでぶらり</h4>
      <hr>
      <div class="list-group">
        <?php for($i = 0; $i < count($tours); $i++){ ?>
          <a class="list-group-item btn btn-defaul btn-raised" href="showtourdetail?tour_id=<?php echo $tours[$i]['Tour']['id']?>">
              <div style="background-color: rgba(255,255,255,0.3); margin-left:-100px; margin-right:-100px;">
                <h5 class="list-group-item-heading" style="color: #222;">
                    <?php echo $tours[$i]['Tour']['name'] ?>
                </h5>
              </div>
          </a>
          <?php } ?>
      </div>
    </div>
</div>
