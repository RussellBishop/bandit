$(function(){
	 
	var form = $('#addResult');
	 
    function processForm(e){
        
        $.ajax({
		    url: form.attr('action'),
		    data: form.serialize(),
		    type: "post",
		    contentType: 'application/x-www-form-urlencoded',
		    dataType: "text",
		    success: function(data) {
			    
		        var results = $.parseJSON(data);
		        
		        console.log(results);
		        
				$('[data-id="' + results['winnerId'] + '"]')
					.find('.rating').text(results['winnerRating']);
				$('[data-id="' + results['winnerId'] + '"]')
					.append('<span class="rating-difference text-success">+'+results['winnerDifference']+'</span>');
					
				$('[data-id="' + results['loserId'] + '"]')
					.find('.rating').text(results['loserRating']);
				$('[data-id="' + results['loserId'] + '"]')
					.append('<span class="rating-difference text-danger">'+results['loserDifference']+'</span>');
					
				$('.rating-difference').delay(2000).fadeOut(500, function() { $(this).remove(); });
				
				/* update using countNum
				$({countNum: 1086}).animate({countNum: 1186}, {
				  duration: 8000,
				  easing:'linear',
				  step: function() {
				    $('[data-id="1"]').find('.rating').text(Math.floor(this.countNum));
				  },
				  complete: function() {
				    console.log('finished');
				  }
				});
				*/
				
				$(form).find('select').each(function() {
					
					$(this).val($(this).find('option:first').val());
					
				});
		        
		    }
		});
        
        /* throw errors 
        if ( !$(form).find('.amount').val() || !$(form).find('.type').val() ) {
			
			if ( !$(form).find('.amount').val() ) {
				$('.amount').addClass('error');
			}
			
			if ( !$(form).find('.type').val() ) {
				$('.select2').addClass('error');
			}
		}
		
		*/
		
		/* post it 
		else {
			
			var sendspendearn = $(".submit-form[clicked=true]").val()
        
	        $(form).addClass('loading');
	        
	            $.ajax({
	                url: form.attr('action'),
	                dataType: 'text',
	                type: 'post',
	                contentType: 'application/x-www-form-urlencoded',
	                data: $(form).serialize()+'&'+$.param({ 'send-spend-earn': sendspendearn }),
	                
	                success: function( data, textStatus, jQxhr ){
		                
		                var newdata = $.parseJSON(data);
		                
		                $('.total-until .credit')
		                	.addClass('animate-zoomAway')
		                	.delay(300)
		                	.queue(function(){
			                	
								$(this).html(newdata['newtotal'])
								.removeClass('animate-zoomAway')
								.addClass('animate-zoomTowards')
								.dequeue();
								
								$('body').addClass('status-counted').dequeue();
							})
							.delay(1500)
							.queue(function(){
								$(this).removeClass('animate-zoomTowards')
								.dequeue();
								
								$('body').removeClass('status-counted').dequeue();
							});
						
						$(form).removeClass('loading');
						
						if (newdata['isbudget'] == 'yes') {
							
							var template = _.template($('#budget-remaining').html());
        
				            $('body').append(template({
					            budgettype: newdata['budgettype'],
				                budgetremaining: newdata['budgetremaining'],
				            }));
							
						} else if (newdata['spentthismonth'] < 0) {
							
							
						}
						
						// reset fields
						$(form).find('input').val('');
						$('.type').select2('val', '');
						
						// load in new records
						$(".activity").load("index.php .activity .records");
											
	                },
	                
	                error: function( jqXhr, textStatus, errorThrown ){
	                    console.log( errorThrown );
	                }
	            });
	            
	    }
	    
	    */

        e.preventDefault();
    }

    $(form).submit(processForm);
        
});