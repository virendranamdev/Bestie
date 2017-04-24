<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">










        <script type="text/javascript" src="/js/lib/dummy.js"></script>








        <link rel="stylesheet" type="text/css" href="/css/result-light.css">




        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>



        <script type="text/javascript" src="https://cdn.rawgit.com/jasondavies/d3-cloud/v1.2.1/build/d3.layout.cloud.js"></script>



        <style type="text/css">

        </style>

        <title>Tag cloud using d3-cloud and D3.js by plantface</title>







        <script type='text/javascript'>//<![CDATA[
            window.onload = function () {
        // First define your cloud data, using `text` and `size` properties:
                var textGlobe = $("#textGlobe").val();
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


    </head>

    <body>
        <div id="cloud"></div>


    </body>

</html>

