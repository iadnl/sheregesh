<?php
$access = new \Core\Access;
?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
					<h1 class="static-fullstory__title"><?= $static_page['title'] ?></h1>
					<div class="static-fullstory static-fullstory__aa">
						<div class="row">
							<div class="col-md-4">
								<div class="card"> <img src="/web/asset/img/meet/image1.png" class="card-img-top" alt="...">
									<div class="card-body">
										<h5 class="card-title">Этот текст написан для макета.</h5>
										<p class="card-text">Об искусственном интеллекте, информационных технологиях, самоорганизации и совершенствовании собственных знаний мы поговорим на форуме "Область будущего" с Анатолием Вассерманом.</p>
										<p class="card-text">Мысль дня от Анатолия Александровича:</p>
										<p class="card-text">"Русская цивилизация самобытная и самая гуманная из существующих когда-либо!"</p>
										<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Регистрация</button>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card"> <img src="/web/asset/img/meet/image3.png" class="card-img-top" alt="...">
									<div class="card-body">
										<h5 class="card-title">Правильное утро айтишника выглядит так</h5>
										<p class="card-text">Зарядимся энергией на весь день Хатха-йога, бассейн или зарядка с тренером в живописном месте - решать вам.</p>
										<p class="card-text">Ловим дзен и вдохновляемся на новый продуктивный день и командную работу! Впереди много работы</p>
										<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Регистрация</button>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card"> <img src="/web/asset/img/meet/image2.png" class="card-img-top" alt="...">
									<div class="card-body">
										<h5 class="card-title">ГосСтарт вместе с Губернатором Липецкой области Игорем Артамоновым.</h5>
										<p class="card-text">На встрече молодые люди будут иметь возможность пообщаться с руководителем региона, что называется «без галстуков», послушать историю успеха о том, как Игорь Георгиевич пришел на госслужбу, а также задать свои интересующие вопросы</p>
										<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Регистрация</button>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Мероприятие</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<h3>Вы успешно зарегистрированы</h3> </div>
			</div>
		</div>
	</div>