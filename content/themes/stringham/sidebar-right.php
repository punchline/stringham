<?php
/**
 * The Sidebar containing the right user menu area.
 *
 * @package Stringham
 */
?>

<!--OffCanvas Menu -->
<aside class="user-menu"> 

	<!-- Tabs -->
	<div class="tabs-offcanvas">
		<ul class="nav nav-tabs nav-justified">
			<li class="active">
				<a href="#userbar-one" data-toggle="tab">Main</a>
			</li>
			<li>
				<a href="#userbar-two" data-toggle="tab">Users</a>
			</li>
			<li>
				<a href="#userbar-three" data-toggle="tab">ToDo</a>
			</li>
		</ul>
		<div class="tab-content"> 
		
			<!--User Primary Panel-->
			<div class="tab-pane active" id="userbar-one">
				<div class="main-info">
					<div class="user-img"><img src="http://placehold.it/150x150" alt="User Picture" /></div>
					<h1>Anton Durant <small>Administrator</small></h1>
				</div>
				<div class="list-group"> <a href="#" class="list-group-item"><i class="fa fa-user"></i>Profile</a> <a href="#" class="list-group-item"><i class="fa fa-cog"></i>Settings</a> <a href="#" class="list-group-item"><i class="fa fa-flask"></i>Projects<span class="badge">2</span></a>
					<div class="empthy"></div>
					<a href="#" class="list-group-item"><i class="fa fa-refresh"></i>Updates<span class="badge">5</span></a>
					<a href="#" class="list-group-item"><i class="fa fa-comment"></i>Messages<span class="badge">12</span></a>
					<a href="#" class="list-group-item"><i class="fa fa-comments"></i> Comments<span class="badge">45</span></a>
					<div class="empthy"></div>
					<a href="#" data-toggle="modal" class="list-group-item lockme"><i class="fa fa-lock"></i> Lock</a>
					<a data-toggle="modal" href="#" class="list-group-item goaway"><i class="fa fa-power-off"></i> Sign Out</a>
				</div>
			</div>
				
			<!--User Chat Panel-->
			<div class="tab-pane" id="userbar-two">
				<div class="chat-users-menu"> 
					<!--Adding Some Scroll-->
					<div class="nano">
						<div class="nano-content">
							<div class="buttons">
								<div class="btn-group btn-group-xs">
									<button type="button" class="btn btn-default">Friends</button>
									<button type="button" class="btn btn-default">Work</button>
									<button type="button" class="btn btn-default">Girls</button>
								</div>
							</div>
							<ul>
								<li><a href="#"><span class="chat-name">Gluck Dorris</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span><span class="badge">5</span></a></li>
								<li><a href="#"><span class="chat-name">Anton Durant</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Spiderman</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Muchu</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-default">Offline</span></a></li>
								<li><a href="#"><span class="chat-name">Mr. Joker</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Chewbacca</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">The Piggy</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Anton Durant</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Spiderman</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Muchu</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Anton Durant</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Spiderman</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Muchu</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Anton Durant</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Spiderman</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Muchu</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Anton Durant</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-default">Offline</span></a></li>
								<li><a href="#"><span class="chat-name">Spiderman</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
								<li><a href="#"><span class="chat-name">Muchu</span><span class="user-img"><img src="http://placehold.it/150x150" alt="User"/></span><span class="label label-success">Online</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
				
				<!--User Tasks Panel-->
			<div class="tab-pane" id="userbar-three">
				<div class="nano"> 
					<!--Adding Some Scroll-->
					<div class="nano-content">
						<div class="small-todos">
							<div class="input-group input-group-sm">
								<input id="new-todo" placeholder="Add ToDo" type="text" class="form-control">
								<span class="input-group-btn">
								<button id="add-todo" class="btn btn-default" type="button"><i class="fa fa-plus-circle"></i></button>
								</span>
							</div>
							<section id="task-list">
								<ul id="todo-list">
								</ul>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /tabs --> 

</aside>
<!-- /Offcanvas user menu--> 