<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Stringham
 */
?>

        <!-- /Widgets Row End Grid--> 
      </div>
      <!-- / Content Wrapper --> 
    </div>
    <!--/MainWrapper--> 
  </div>
<!--/Smooth Scroll--> 


<!-- scroll top -->
<div class="scroll-top-wrapper hidden-xs">
    <i class="fa fa-angle-up"></i>
</div>
<!-- /scroll top -->


<!--Help Modal-->
<div class="modal" id="help-box">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <i class="fa fa-lock"></i> </div>
      <div class="modal-body text-center"><h2>How to Play!</h2>
      <ul>
	      <li>Find and mark all the words inside the box before your points fall to zero.</li>
	      <li>The words may be horizontally, vertically, diagonally, and even backwards</li>
	      <li>If you give up searching for a word, use the button next to the word.</li>    
      </ul>
      
      </div>
      <div class="modal-footer">
        <h4>Good Luck!</h4>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 
<?php wp_footer(); ?>
</body>
</html>