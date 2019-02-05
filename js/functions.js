    $( document ).ready(getCash(), getPoints());
    $(document).ready(function(){
        $('.sell-tab').hide();
        $('#stock1_sell,#stock2_sell,#stock3_sell,#stock4_sell').click(function(){
            $('.buy-tab').hide();
            $('.sell-tab').show();
        });
        $('#stock1_buy,#stock2_buy,#stock3_buy,#stock4_buy').click(function(){
            $('.buy-tab').show();
            $('.sell-tab').hide();
        });
    });

    $(document).on('click', ".btn-minuse",function(){
        if($(this).parent().siblings('input').val() <= 0){
            $(this).parent().siblings('input').val(parseInt(0));
        }else{
            $(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) - 1)
        }
    })

    $(document).on('click', '.btn-pluss',function(){   
        var qty = $('.companyStock>.quantity').html(); 
        if($(this).parent().siblings('input').val() == qty){
            $(this).parent().siblings('input').val(parseInt(qty));
        }else{
            $(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) + 1)
        }
    })
    

    // $(document).on("click",".btn-purchase",function(){
    //     var qty = $('.form-control').val();
    //     console.log($(''))
    //     purchaseCompanyStock(qty);
    // });

    
    function cancelStock($id){
        if(!confirm("Are you sure you want to cancel your listing?")){
            return false;
        }

        $.ajax({
            url: 'php/stock_cancel.php',
            method: 'post',
            data:{
                id: $id,
            },
            success:function(response){
                if(response == 'You don\'t have any stock for cancellation.'){
                    alert(response);
                }else{
                    showStocksOwned(response);
                }
            }
        })
    }

    function sellStock($id){
        var priceStock = prompt("Please enter your listing price");
        if (priceStock == null) {
            return false;
        }else if(priceStock <= 0){
            alert("The price is invalid");
            return false;
        }

        $.ajax({
            url: 'php/stock_sell.php',
            type: 'post',
            data:{
                id: $id,
                price: priceStock,
            },
            success:function(response){
                if(response == 'You don\'t have any stock for sale.'){
                    alert(response);
                }else{
                    alert("The stock "+response+" has been listed for sale.");
                    showStocksOwned(response);
                }
            }
        })
    }

    function purchaseStock($id){
        if(!confirm("Are you sure you want to purchase this stock?")){
            return false;
        }
        $.ajax({
            url:'php/stock_purchase.php',
            type: 'post',
            data:{
                id: $id,
            },
            success:function(result){
                if(result === 'Stock is unavailable for purchase.' || result === "You don't have enough cash to purchase the stocks."){
                    alert(result);
                }else{
                    getCash();
                    alert("You have successfully purchase the stock!");
                    showStocks(result);
                }
            }
        });
    }

    function purchaseCompanyStock(stockName){
        var qty = $('.form-control').val();
        var price = $('.companyStock>.price').html();
        var total_price = price*qty;
        if(confirm("Proceed with the purchase?\nThe total price is "+total_price+".")){
            if(qty <= 0){
                alert("The quantity entered is invalid.");
            }else{
                $.ajax({
                    url: 'php/purchaseMultipleStocks.php',
                    type: 'post',
                    data:{
                        quantity: qty,
                        stock: stockName,
                        owner: stockName,
                    },
                    // dataType: 'json',
                    success:function(result){
                        if(result === 'Stock is unavailable for purchase.' || result === "You don't have enough cash to purchase the stocks." || result === 'Insufficient stock for purchase.'){
                            alert(result);
                        }else{
                            getCash();
                            alert("You have successfully purchase the stocks!");
                            showStocks(result);
                        }
                    }
                })
            }
        }else{
            alert("The purchase is cancelled.");
        }
        
    }


    function getCash(){
        $.ajax({
            url: 'php/stats.php',
            type: 'post',
            data:{
                choice: 1,
            },
            success:function(result){
                //console.log(result);
                $('#cash-result').html(result)
            }
        })
    }

    function getPoints(){
        $.ajax({
            url: 'php/stats.php',
            type: 'post',
            data:{
                choice: 2,
            },
            success:function(result){
                $('#points-result').html(result)
            }
        })
    }

    //show stocks for sale
    function showStocks($stockName){
        $.ajax({
            url: 'php/stock_show.php',
            type: 'GET',
            data:{
                name: $stockName,
            },
            dataType: 'json',
            success:function(result){
                jQuery('.STOCK1S').empty();
                var counter = 0;
                var companyStock = "";
                var price = 0;
                var stocks = "";
                var arrayID = [];
                $.each(result, function(key, value) { //for each value in list will be in value
                    var name = value['name']; //name of stock
                    var owner = value['owner']; //name of stock owner
                    var id = value['id']; //id of owner, used to passed into backend to purchase stocks
                    if($stockName == owner){
                        counter++;
                        price = parseFloat(value['price']);
                        arrayID.push(id);
                    }else{
                        stocks += '<button class="btn col-xs-3 stocks_box alert" onclick="purchaseStock(\'' + id + '\')">' + '<strong>' +
                        value['name'] +'</strong>' + '<br>' + value['price'] + '<br>' + 
                        value['owner'] + '<br>' +'</button>' + '<hr>';
                    }                    
                    
                });
                if(counter != 0){
                    companyStock = "<div class='btn btn-primary companyStock'>"+$stockName+"<br>"+$stockName+"<br>Price: "+"<span class='price'>"+price+"</span >"+"<br>"+"available: "+"<span class='quantity'>" +counter+"</span>"+"<br>"+ '<div class="input-group"><span class="input-group-btn"><button class="btn btn-white btn-minuse" type="button">-</button></span><input type="number" class="form-control no-padding add-color text-center height-25" maxlength="3" value="0"><span class="input-group-btn"><button class="btn btn-red btn-pluss" type="button">+</button></span></div>'+"<button class='btn btn-success btn-purchase' onclick='purchaseCompanyStock(\"" + $stockName + "\")'>Purchase</button>"+"</div><br>" 
                                
                }
                $(".STOCK1S").append(companyStock).hide().fadeIn(700);
                if(stocks != ""){
                    $(".STOCK1S").append(stocks).hide().fadeIn(700); //Value as a specific item from list. 
                }
            }
        })
    }

    function showStocksOwned($stockName){
        $.ajax({
            url: 'php/stock_owned.php',
            type: 'GET',
            data:{
                name: $stockName,
            },
            dataType: 'json',
            success:function(result){
                jQuery('.stocks-owned').empty();
                $('.ownedQty').empty();
                var length = 0;
                length = result.length;
                $('.ownedQty').html(length);
                $.each(result, function(key, value) { //for each value in list will be in value
                    var name = value['name'];
                    var owner = value['owner'];
                    var id = value['id'];
                    var available = value['available'];

                    if(available == 1){
                        status = "Listed";
                    }else{
                        status = "Not listed";
                    }
                    const color = available == 0 ? "'btn col-xs-3 stocks_box alert' style='background:green;color:white;'":
                    "'btn col-xs-3 stocks_box alert' style='background:red;color:white;'";
                    
                    var sell = '<button onclick="sellStock(\'' + id + '\')" class=' + color + '>' + value['name'] + '      ' + '<br>' + value['price'] + '<br>' + status + '<br>'+
                        '</button>';

                    var cancel = '<button onclick="cancelStock(\'' + id + '\')" class=' + color + '>' + value['name'] + '      ' + '<br>' + value['price'] + '<br>' + status + '<br>'+
                        '</button>';

                    if(available == 0){
                        var div = sell;
                    }else{
                        var div = cancel;
                    }

                    $(".stocks-owned").append(div).hide().fadeIn(700); //Value as a specific item from list. 
                });
                
            }
        })
    }
