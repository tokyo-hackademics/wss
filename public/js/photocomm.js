/* photocomm.js */

(function($){
	$.fn.photoComm = function(options) {
		var settings = $.extend({
			commentImage: "smile.jpg",
			comments: [],
		}, options);

		return this.each(function(){
			$(this).find("img, canvas").click(
				function(e){
					deleteEmptyModal();
					if (!isModalOpen()) {
						var	$$			= $(this),
							$parent 	= $(this).parent(),
							offset 		= $$.offset(),
							pos_x		= e.offsetX, //+ offset.left,
							pos_y		= e.offsetY, //+ offset.top,
							$comment 	= getComment("", [], pos_x, pos_y, e.offsetX, e.offsetY);
									
						$parent.append($comment);

						return false;
					}
				}
			);

			$(this).find("img, canvas").each(function(){
				var $parent	= $(this).parent();
				var offset 	= $(this).offset();

				for (var i=0; i < settings.comments.length; i++) {
					var comment = settings.comments[i];

					$parent.append(
						getComment(
							comment.text,
							comment.answer,
							comment.pos_x, //+ offset.left,
							comment.pos_y, //+ offset.top,
							comment.pos_x,
							comment.pos_y
						)
					);
				}
			});

			$(document).click(function(){
				closeModal();
				deleteEmptyModal();
			});

			function getComment(comment, answer, pos_x, pos_y, offsetX, offsetY){
				var $comment 		= $("<div class='comment' style='z-index:100'></div>"),
					$list			= $("<div class='commentList' style='width:350px; position:absolute;'></div>"),
					$cmmodal		= $("<div class='commentModal' style='width:100%;'></div>"),
					$textarea       = $("<textarea name='content' class='commentBody form-control' placeholder='質問を入力' rows='3' cols='10'></textarea>"),
					$commitbutton	= $("<button class='commit btn btn-success' style='padding:6px 12px;margin-top:10px !important; font-size: 14px;'>OK</button>");
					$messages		= $("<p class='left_balloon'>探し物はなんですか？</p><p class='right_balloon'>見つけにくいものです。</p><p class='left_balloon'>鞄の中も机の中も探しましたか？</p><br class='clear_balloon'/>");
					/*<p class='left_balloon'>今、時間ある？</p><br class='clear_balloon'/>
					$deletebutton	= $("<button class='commit btn btn-w'>delete</button>");

				$deletebutton.click(function(e){
					$(this).parent().parent().remove();
				});
				*/
				$comment.css("position", "absolute");
				$comment.css("left", pos_x);
				$comment.css("top", pos_y);
				
				if (comment.length > 0) {
					$modal.append($("<div class='question'>" + comment + "</div>"));
				}

				for (var i=0; i < answer.length; i++) {
					var ans = answer[i];

					$modal.append($("<div class='answer'>" + ans.answer + "</div>"));
				}

				$.data($comment.get(0), "pos_x", pos_x);
				$.data($comment.get(0), "pos_y", pos_y);

				$cmmodal.append($textarea);
				$cmmodal.append($commitbutton);

				$comment.click(function(e){
					$list.fadeIn(500);
					return false;
				});

				$commitbutton.click(function(){
					$list.fadeOut(500);
					return false;
				});

				$list.append($messages);
				$list.append($cmmodal);

				$img = $("<img src='" + settings.commentImage + "' width='32px' height='32px' style='position:relative; top:-32px; opacity:0;'/>");
				$img.animate({top:0, opacity:1}, 500, "easeInOutCirc", function(){
					$comment.click();
				});
				$comment.append($img);
				
				$puff = $("<img src='/css/puff.svg' width='32px' height='32px' style='position: relative; top: 16px; left: -32px;'/>");
				$comment.append($puff);
				$comment.append($list);

				$list.css("bottom", '32px');
				$list.css("left", '-175px');
				$list.hide();
				/*
				setTimeout(function(){
					$puff.hide();
				},1000);
				*/
				return $comment;
			}

			function closeModal(){
				$(".commentModal").each(function(){
					$(this).hide(100);
				});
			}

			function deleteEmptyModal(){
				$(".commentModal").each(function(){
					if ($(".answer, .question", this).length == 0 && $(".commentBody", this).first().val().length == 0) {
						$(this).parent().parent().remove();
					}
				});
			}

			function isModalOpen(){
				var isOpen = false;
				$(".commentModal").each(function(){
					if ($(this).css("display") != 'none'){
						isOpen = true;
					}
				});

				return isOpen;
			}

		});
	}

	$.fn.getComments = function(){
		var comments = [];

		$(".comment", this).each(function(){
			var commentBody = $(".commentBody", this).first().val();

			if (commentBody.length > 0){
				var comment = {};

				comment.text = commentBody;
				comment.pos_x = $.data($(this).get(0), "pos_x");
				comment.pos_y = $.data($(this).get(0), "pos_y");

				comments.push(comment);
			}
		});

		return comments;
	};
})(jQuery);