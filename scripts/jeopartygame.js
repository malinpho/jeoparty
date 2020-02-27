var lastClicked;
var grid = clickableGrid(6,6,function(el,row,col,i){
    el.className='mouseover';
    if (lastClicked) lastClicked.className='';
    lastClicked = el;
});

document.body.appendChild(grid);

function clickableGrid(rows, cols, callback){
    var i=0;
    var grid = document.createElement('table');
    grid.className = 'grid';
    for (var r=0;r<rows;++r){
        var tr = grid.appendChild(document.createElement('tr'));
        for (var c=0;c<cols;++c){
            var cell = tr.appendChild(document.createElement('td'));
            cell.addEventListener('mouseover',(function(el,r,c,i){
                return function(){
                    callback(el,r,c,i);
                }
            })
            (cell,r,c,i),false);
        }
    }
    return grid;
}
