// var lastClicked;
// var grid = clickableGrid(6,6,function(el,row,col,i){
//     el.className='mouseover';
//     if (lastClicked) lastClicked.className='';
//     lastClicked = el;
// });
//
// document.body.appendChild(grid);

// function clickableGrid(rows, cols, callback){
//     var i=0;
//     var grid = document.createElement('table');
//     grid.className = 'grid';
//     for (var r=0;r<rows;++r){
//         var tr = grid.appendChild(document.createElement('tr'));
//         for (var c=0;c<cols;++c){
//             var cell = tr.appendChild(document.createElement('td'));
//             if (r != 0) {
//               cell.innerHTML = "$500";
//               cell.addEventListener('mouseover',(function(el,r,c,i){
//                 return function(){
//                     callback(el,r,c,i);
//                 }
//             })
//             (cell,r,c,i),false);
//           };
//         }
//     }
//     return grid;
// }
//https://www.taniarascia.com/how-to-connect-to-an-api-with-javascript/



const app = document.getElementById('root');

const logo = document.createElement('img');
logo.src = 'logo.png';

const container = document.createElement('div');
container.setAttribute('class', 'container');

app.appendChild(logo);
app.appendChild(container);

var request = new XMLHttpRequest();
request.open('GET', 'http://jservice.io/api/clues', true);
request.onload = function () {

  // Begin accessing JSON data here
  var data = JSON.parse(this.response);
  if (request.status >= 200 && request.status < 400) {
    data.forEach(movie => {
      const card = document.createElement('div');
      card.setAttribute('class', 'card');

      const h1 = document.createElement('h1');
      h1.textContent = movie.answer;

      const p = document.createElement('p');
      movie.answer = movie.answer.substring(0, 300);
      p.textContent = `${movie.answer}...`;

      container.appendChild(card);
      card.appendChild(h1);
      card.appendChild(p);
    });
  } else {
    const errorMessage = document.createElement('marquee');
    errorMessage.textContent = `Gah, it's not working!`;
    app.appendChild(errorMessage);
  }
}

request.send();
