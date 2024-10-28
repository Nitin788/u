<!-- End Footer -->
<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
        <nav class="pull-left">
            <ul class="nav">
            </ul>
        </nav>
        <div class="copyright">
            © Copyright <strong><span>@2024</span></strong><a href="https://plutotours.in/">PTW Holidays Private Limited
            </a>
        </div>
        <div>
            Developed by
            <a href="#">Nitin Jamwal</a>
        </div>
    </div>
</footer>
<!-- Start Footer -->
<!--   Core JS Files   -->
<script src="{{asset('assets/js/core/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
<!-- jQuery Scrollbar -->
<script src="{{asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

<!-- Chart JS -->
<script src="{{asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

<!-- jQuery Sparkline -->
<script src="{{asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

<!-- Chart Circle -->
<script src="{{asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

<!-- Datatables -->
<script src="{{asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

<!-- Bootstrap Notify -->
<script src="{{asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<!-- jQuery Vector Maps -->
<script src="{{asset('assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
<script src="{{asset('assets/js/plugin/jsvectormap/world.js')}}"></script>

<!-- Sweet Alert -->
<script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

<!-- Kaiadmin JS -->
<script src="{{asset('assets/js/kaiadmin.min.js')}}"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{asset('assets/js/setting-demo.js')}}"></script>
<script src="{{asset('assets/js/demo.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
    });

    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
    });

    //To dynamically add input fields for places and prices
    let placeIndex = 1; // Start index for new places

    document.getElementById('add-more-places').addEventListener('click', function () {
        const placesContainer = document.getElementById('places-container');

        // Create a new input group
        const newPlaceGroup = document.createElement('div');
        newPlaceGroup.className = 'input-group mb-2';
        newPlaceGroup.id = `place-group-${placeIndex}`;
        newPlaceGroup.innerHTML = `
            <input type="text" name="sightseeing[${placeIndex}]" class="form-control" placeholder="Enter Places" required>
            <input type="number" name="suv_price[${placeIndex}]" class="form-control" placeholder="SUV Price" required>
            <input type="number" name="sedan_price[${placeIndex}]" class="form-control" placeholder="Sedan Price" required>
            <input type="number" name="tampo_travel_price[${placeIndex}]" class="form-control" placeholder="Tampo Travel Price" required>
            <input type="number" name="hatchback_price[${placeIndex}]" class="form-control" placeholder="Hatchback Price" required>
            <input type="number" name="minivan_price[${placeIndex}]" class="form-control" placeholder="Minivan Price" required>
            <button type="button" class="btn btn-danger remove-place" style="margin-left: 10px;">Remove</button>
        `;

        placesContainer.appendChild(newPlaceGroup);
        placeIndex++;

        // Add event listener to the remove button
        newPlaceGroup.querySelector('.remove-place').addEventListener('click', function () {
            placesContainer.removeChild(newPlaceGroup);
        });
    });

    // Add initial event listener to the remove button of the first group
    document.querySelector('.remove-place').addEventListener('click', function () {
        const firstPlaceGroup = document.getElementById('place-group-0');
        firstPlaceGroup.parentNode.removeChild(firstPlaceGroup);
    });


</script>