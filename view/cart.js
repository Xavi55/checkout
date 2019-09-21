window.onload=()=>
{
    getSummary();
};
function getSummary()
{
    let args={action:"summary"}
    $.get('../index.php',args,data=>
    {
        data=JSON.parse(data);
        //console.log(data);
        let total=0;
        for(i in data)
        {
            $(`#sitems`).append(`
                <li class="list-group-item">x${data[i]["count"]}  ~  ${data[i][0]["name"].replace(/-/g,' ')} @ $${parseFloat(data[i][0]["price"]).toFixed(2)}</li>
            `);
            total+=data[i][0]["price"]*parseFloat(data[i]["count"]);
            //total+=parseFloat(data[i][0]["price"]);
            //console.log(total);
        }
        console.log(total);
        $('#total').text('Current Total: $'+parseFloat(total).toFixed(2));
        //for
        //console.log(total,groups);
    });
}
function checkout()
{
    $('#userform').removeClass('hide');
}
function submit()
{
    let name=$('#formname').val();
    let card=$('#cardno').val();
    let phone=$('#phoneno').val();

    if(!name||!card||!phone)
    {
        alert('Complete the form');
    }
    else if(card.match(/\d/g).length!=16)
    {
        alert("Enter a real card #");
    }
    else if(phone.match(/\d/g).length!=10)
    {
        alert("Enter a phone number (ie: 0123456789)");
    }
    else
    {
        $('#prompt').html(`
            <h2 class=center>Thanks ${name}!<br/>
            Your rentals are getting ready!<br/>
            Print this page for your records<br/>
            <a class="center" href="home.html">×</a>
            </h2>
        `);
        $('#formname').val('');
        $('#cardno').val('');
        $('#phoneno').val('');
        $.get('../index.php',{action:"clearCart"},data=>
        {
            if(data)
            {
                console.log('cartCleared');
            }
        });
    }
}