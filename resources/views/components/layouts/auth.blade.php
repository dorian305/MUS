<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        <!-- Sweet alert -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

        <!-- Axios -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
        {{ $slot }}

        <script>
            const componentInner = document.querySelector("#component-inner");
            
            // Toggle class
            const toggleClass = (elem, classs) => elem.classList.toggle(classs);

            // Toggle form element read only state
            const formReadOnly = state => {
                document.querySelectorAll("form input, form select, form textarea, form button").forEach(element => {
                    element.disabled = state;
                });
            }

            // Check if any of the form inputs are not populated
            const incompleteFormData = data => {
                return Object.values(data).some(value => value.trim() === "");
            }

            // Build a description list for the nice error display
            const generateDescriptionList = errorObj => {
                const dl = document.createElement("dl");
                dl.classList.add("row");

                Object.entries(errorObj).forEach(([errorName, errors]) => {
                    const dt = document.createElement("dt");

                    dt.classList.add("col-sm-3", "text-start");
                    dt.textContent = errorName.charAt(0).toUpperCase() + errorName.slice(1);
                    dl.appendChild(dt);

                    const dd = document.createElement("dd");
                    dd.classList.add("col-sm-9", "text-end");
                    errors.forEach(error => {
                        const errorText = document.createElement("p");
                        
                        errorText.textContent = error;
                        dd.appendChild(errorText);
                    });

                    dl.appendChild(dd);
                });

                return dl;
            }

        </script>
    </body>
</html>
