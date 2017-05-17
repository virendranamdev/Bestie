<!DOCTYPE html>
<html>
    <head>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>



        <script type="text/javascript" src="https://cdn.rawgit.com/jasondavies/d3-cloud/v1.2.1/build/d3.layout.cloud.js"></script>


        <script type='text/javascript'>//<![CDATA[
            window.onload = function () {
                // First define your cloud data, using `text` and `size` properties:
                var textGlobe = $("#textGlobe").val();
                // just copy twice for extra data, else the cloud is a little boring

                var skillsToDraw = JSON.parse(textGlobe);

                // Next you need to use the layout script to calculate the placement, rotation and size of each word:

                var width = 400;
                var height = 300;
                var fill = d3.scale.category20();

                d3.layout.cloud()
                        .size([width, height])
                        .words(skillsToDraw)
                        .rotate(function () {
                            //this is for rotation of text
                            return ~~(Math.random() * 2) * 10;
                        })
                        .font("Impact")
                        .fontSize(function (d) {
                            return d.size;
                        })
                        .on("end", drawSkillCloud)
                        .start();

                // Finally implement `drawSkillCloud`, which performs the D3 drawing:

                // apply D3.js drawing API
                function drawSkillCloud(words) {
                    d3.select("#cloud").append("svg")
                            .attr("width", width)
                            .attr("height", height)
                            .append("g")
                            .attr("transform", "translate(" + ~~(width / 2) + "," + ~~(height / 2) + ")")
                            .selectAll("text")
                            .data(words)
                            .enter().append("text")
                            .style("font-size", function (d) {
                                return d.size + "px";
                            })
                            .style("-webkit-touch-callout", "none")
                            .style("-webkit-user-select", "none")
                            .style("-khtml-user-select", "none")
                            .style("-moz-user-select", "none")
                            .style("-ms-user-select", "none")
                            .style("user-select", "none")
                            .style("cursor", "default")
                            .style("font-family", "Impact")
                            .style("fill", function (d, i) {
                                return fill(i);
                            })
                            .attr("text-anchor", "middle")
                            .attr("transform", function (d) {
                                return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                            })
                            .text(function (d) {
                                return d.text;
                            });
                }

                // set the viewbox to content bounding box (zooming in on the content, effectively trimming whitespace)

                var svg = document.getElementsByTagName("svg")[0];
                var bbox = svg.getBBox();
                var viewBox = [bbox.x, bbox.y, bbox.width, bbox.height].join(" ");
                svg.setAttribute("viewBox", viewBox);
            }//]]> 

        </script>
<style>
#canvas1{
		background-color : white;
		border : none;
		}		
</style>
    </head>

    <body>
        <div id="canvas1" style="background-color : white;border : none;">
            <div id="cloud"></div>
        </div>
        <!--------------- image capture ------->
        <div class="form-group">
            <div id="design1">
                <div id="controls1">
                    <input type="button" value="Download" id="capture1" /><br /><br />	
                </div>
            </div>
        </div>
        <!--------------- image capture ------->

        <script type="text/javascript">
            /*************************** download image *************************/
            
          
            
            $(function () {

                $('#capture1').click(function () {
                    //get the div content
                    div_content = document.querySelector("#canvas1");
                    //alert('hi');
                    //make it as html5 canvas
                  console.log(div_content);
                    
                  
                    html2canvas(div_content).then(function (canvas) {
                        background :'#FFFFFF',
                        //alert('ho');
                        //change the canvas to jpeg image
                        data = canvas.toDataURL('image/jpeg');
//window.open(data);
                        //then call a super hero php to save the image
                        save_img(data, 'wordcloud.jpeg');
                    });
                });
            });





            function save_img(data, imgname) {
               //    alert(data);
                var img = document.createElement('img');
              
                img.src = data;
                 document.body.style.backgroundColor = "#f3f3f3";
                var a = document.createElement('a');
//a.setAttribute("download", "wordcloud.jpeg");
                a.setAttribute("download", imgname);
                a.setAttribute("href", data);
                a.appendChild(img);
                var w = open();
                w.document.title = 'Download Image';
                w.document.body.innerHTML = 'Click On Image for Download';
                w.document.body.appendChild(a);
            }

            /******************************** / download image *********************/
        </script>

    </body>

</html>

