let dataJenis = []
$.ajax({
    url : '/api/getDataJenis',
    type : 'GET',
    success : function(res){
        console.log(res);
    }
})

new Chart(document.getElementById('chart-jenis'),
    {
        type : 'pie',
        data : {
            labels : [
                'plastik',
                'kaca'
            ],
            datasets : [{
                label : 'Data jenis',
                data : [
                    9,10
                ],
                backgroundColor : [
                    'red','blue'
                ]
            }]
        },
        options : {
            plugins : {
                legend : {
                    onClick : function(e){
                        null
                    }
                }
            }
        }
    }
)