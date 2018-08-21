<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dol-bls-api</title>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>

    <?php
    $configIni = __DIR__ . "/config/api.ini";

    $key = false;
    if (file_exists($configIni)) {
        $config = parse_ini_file($configIni);

        $key = array_key_exists('dol-bls-key', $config) ?
                $config['dol-bls-key'] : false;
    }
    ?>
</head>
<body>
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand"
           href="https://github.com/jrquick17/dol-bls-api">
            <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB3aWR0aD0iMTc5MiIg%0D%0AaGVpZ2h0PSIxNzkyIiB2aWV3Qm94PSIwIDAgMTc5MiAxNzkyIiB4bWxucz0iaHR0cDovL3d3dy53%0D%0AMy5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik04OTYgMTI4cTIwOSAwIDM4NS41IDEwM3QyNzkuNSAy%0D%0ANzkuNSAxMDMgMzg1LjVxMCAyNTEtMTQ2LjUgNDUxLjV0LTM3OC41IDI3Ny41cS0yNyA1LTQwLTd0%0D%0ALTEzLTMwcTAtMyAuNS03Ni41dC41LTEzNC41cTAtOTctNTItMTQyIDU3LTYgMTAyLjUtMTh0OTQt%0D%0AMzkgODEtNjYuNSA1My0xMDUgMjAuNS0xNTAuNXEwLTExOS03OS0yMDYgMzctOTEtOC0yMDQtMjgt%0D%0AOS04MSAxMXQtOTIgNDRsLTM4IDI0cS05My0yNi0xOTItMjZ0LTE5MiAyNnEtMTYtMTEtNDIuNS0y%0D%0AN3QtODMuNS0zOC41LTg1LTEzLjVxLTQ1IDExMy04IDIwNC03OSA4Ny03OSAyMDYgMCA4NSAyMC41%0D%0AIDE1MHQ1Mi41IDEwNSA4MC41IDY3IDk0IDM5IDEwMi41IDE4cS0zOSAzNi00OSAxMDMtMjEgMTAt%0D%0ANDUgMTV0LTU3IDUtNjUuNS0yMS41LTU1LjUtNjIuNXEtMTktMzItNDguNS01MnQtNDkuNS0yNGwt%0D%0AMjAtM3EtMjEgMC0yOSA0LjV0LTUgMTEuNSA5IDE0IDEzIDEybDcgNXEyMiAxMCA0My41IDM4dDMx%0D%0ALjUgNTFsMTAgMjNxMTMgMzggNDQgNjEuNXQ2NyAzMCA2OS41IDcgNTUuNS0zLjVsMjMtNHEwIDM4%0D%0AIC41IDg4LjV0LjUgNTQuNXEwIDE4LTEzIDMwdC00MCA3cS0yMzItNzctMzc4LjUtMjc3LjV0LTE0%0D%0ANi41LTQ1MS41cTAtMjA5IDEwMy0zODUuNXQyNzkuNS0yNzkuNSAzODUuNS0xMDN6bS00NzcgMTEw%0D%0AM3EzLTctNy0xMi0xMC0zLTEzIDItMyA3IDcgMTIgOSA2IDEzLTJ6bTMxIDM0cTctNS0yLTE2LTEw%0D%0ALTktMTYtMy03IDUgMiAxNiAxMCAxMCAxNiAzem0zMCA0NXE5LTcgMC0xOS04LTEzLTE3LTYtOSA1%0D%0AIDAgMTh0MTcgN3ptNDIgNDJxOC04LTQtMTktMTItMTItMjAtMy05IDggNCAxOSAxMiAxMiAyMCAz%0D%0Aem01NyAyNXEzLTExLTEzLTE2LTE1LTQtMTkgN3QxMyAxNXExNSA2IDE5LTZ6bTYzIDVxMC0xMy0x%0D%0ANy0xMS0xNiAwLTE2IDExIDAgMTMgMTcgMTEgMTYgMCAxNi0xMXptNTgtMTBxLTItMTEtMTgtOS0x%0D%0ANiAzLTE0IDE1dDE4IDggMTQtMTR6Ii8+PC9zdmc+" width="30" height="30" alt="">
            dol-bls-api
        </a>

        <form class="form-inline my-2 my-lg-0">
            <a class="navbar-brand"
               href="https://www.jrquick.com">
                <button class="btn btn-outline-success my-2 my-sm-0"
                        type="button">
                    FIND MORE STUFF
                </button>
            </a>
        </form>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="keys">
                    API Key(s)
                </label>

                <input type="text"
                       class="form-control"
                       id="keys"
                       aria-describedby="keys"
                       placeholder="5fbe27e3d430415494c21d3c9e476228"
                       required
                       aria-required="true"
                       <?php echo($key ? 'value="'.$key.'"' : '') ?>/>

                <small id="keysHelp"
                       class="form-text text-muted">
                    Separate with commas to include multiple keys. Your key(s) are not stored but are required, you can apply for
                    <a href="https://data.bls.gov/registrationEngine/"
                       target="_blank">
                        one here.
                    </a>
                </small>

                <div id="error-missing-key"
                     class="invalid-feedback"
                     style="display: none;">
                    At least one API key is required.
                </div>
            </div>

            <div id="accordion">
                <div class="card">
                    <div class="card-header"
                         id="latestHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link"
                                    data-toggle="collapse"
                                    data-target="#latestCollapse"
                                    aria-expanded="true"
                                    aria-controls="latestCollapse">
                                Latest Series
                            </button>
                        </h5>
                    </div>

                    <div id="latestCollapse"
                         class="collapse"
                         aria-labelledby="latestHeading"
                         data-parent="#accordion">
                        <div class="card-body">
                            <input type="hidden"
                                   id="action"
                                   aria-describedby="action"
                                   value="latest"/>

                            <label for="series">
                                Series ID
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="series"
                                   aria-describedby="series"
                                   placeholder="LAUCN040010000000005"
                                   aria-required="false"/>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"
                         id="popularHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link"
                                    data-toggle="collapse"
                                    data-target="#popularCollapse"
                                    aria-expanded="true"
                                    aria-controls="popularCollapse">
                                Popular Series
                            </button>
                        </h5>
                    </div>

                    <div id="popularCollapse"
                         class="collapse"
                         aria-labelledby="popularHeading"
                         data-parent="#accordion">
                        <div class="card-body">
                            <input type="hidden"
                                   id="action"
                                   aria-describedby="action"
                                   value="popular"/>

                            <label for="abbreviation">
                                Survey Abbreviation
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="abbreviation"
                                   aria-describedby="abbreviation"
                                   placeholder="LA"
                                   aria-required="false"/>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"
                         id="specificSeriesHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link"
                                    data-toggle="collapse"
                                    data-target="#specificSeriesCollapse"
                                    aria-expanded="true"
                                    aria-controls="specificSeriesCollapse">
                                Specific Series
                            </button>
                        </h5>
                    </div>

                    <div id="specificSeriesCollapse"
                         class="collapse"
                         aria-labelledby="specificSeriesHeading"
                         data-parent="#accordion">
                        <div class="card-body">
                            <input type="hidden"
                                   id="action"
                                   aria-describedby="action"
                                   value="series"/>

                            <label for="series">
                                Series ID
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="series"
                                   aria-describedby="series"
                                   placeholder="LAUCN040010000000005"
                                   aria-required="false"/>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"
                         id="specificSurveyHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link"
                                    data-toggle="collapse"
                                    data-target="#specificSurveyCollapse"
                                    aria-expanded="true"
                                    aria-controls="specificSurveyCollapse">
                                Specific Survey
                            </button>
                        </h5>
                    </div>

                    <div id="specificSurveyCollapse"
                         class="collapse"
                         aria-labelledby="specificSurveyHeading"
                         data-parent="#accordion">
                        <div class="card-body">
                            <input type="hidden"
                                   id="action"
                                   aria-describedby="action"
                                   value="survey"/>

                            <label for="abbreviation">
                                Survey Abbreviation
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="abbreviation"
                                   aria-describedby="abbreviation"
                                   placeholder="LA"
                                   aria-required="false"/>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"
                         id="surveysHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link"
                                    data-toggle="collapse"
                                    data-target="#surveysCollapse"
                                    aria-expanded="true"
                                    aria-controls="surveysCollapse">
                                Surveys
                            </button>
                        </h5>
                    </div>

                    <div id="surveysCollapse"
                         class="show"
                         aria-labelledby="surveysHeading"
                         data-parent="#accordion">
                        <div class="card-body">
                            <input type="hidden"
                                   id="action"
                                   aria-describedby="action"
                                   value="surveys"/>

                            <small id="surveysCollapseHelp"
                                   class="form-text text-muted">
                                No additional requirements.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <button id="request-button"
                    type="button"
                    class="btn btn-block btn-primary">
                Request
            </button>
        </div>

        <div id="response"
             class="card-body">
        </div>

        <h6 class="card-footer text-muted">
            BLS.gov cannot vouch for the data or analyses derived from these data after the data have been retrieved from BLS.gov.
        </h6>
    </div>

    <script type="text/javascript">
        function displayResponse(response) {
            var json = JSON.parse(response);
            var prettyJson = JSON.stringify(json, null, '\t');

            $('#response').text(prettyJson);
        }

        function getGet() {
            var data = '';

            var abbreviation = $('#abbreviation:visible').val();
            if (abbreviation && abbreviation.length) {
                data += '&abbreviation=' + abbreviation;
            }

            var action = $('#action').val();
            if (action && action.length) {
                data += '&action=' + action;
            }

            var keys = $('#keys').val();
            if (keys && keys.length) {
                data += '&keys=' + keys;
            }

            var series = $('#series:visible').val();
            if (series && series.length) {
                data += '&series=' + series;
            }

            return data;
        }

        function request() {
            var data = getGet();

            $.get('example/api.php?' + data).then(
                function(response) {
                    displayResponse(response);
                }
            );
        }

        function validate() {
            $hasKey = $('#keys').val().length > 0;

            if (!$hasKey) {
                $('#error-missing-key').show();
            } else {
                $('#error-missing-key').hide();
            }

            return $hasKey;
        }

        $('#request-button').click(
            function() {
                if (validate()) {
                    request();
                }
            }
        );
    </script>
</body>
</html>