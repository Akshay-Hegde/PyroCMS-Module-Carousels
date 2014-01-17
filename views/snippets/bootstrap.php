<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
	
	<?php foreach($slides as $slide): ?>
		
			<div class="item <?php echo $slide->ordinal == 0 ? active : '' ?>">
				
					<?php echo $slide['image']['img'] ?>
				<div class="carousel-caption">
			        <?php echo $slide['caption'] ?>
			      </div>
			</div>
			
	<?php endforeach ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>