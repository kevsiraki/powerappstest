<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .record {
            border-bottom: 1px solid #ddd;
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .record:last-child {
            border-bottom: none;
        }

        .record-info {
            flex-grow: 1;
            padding-right: 20px;
        }

        .record-info p {
            margin: 0;
            color: #666;
        }

        .delete-button {
            cursor: pointer;
            color: #d9534f;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .delete-button:hover {
            color: #c9302c;
        }
    </style>

</head>

<body>
    <div id="app" class="container">
        <h1 class="text-center">Internal Records</h1>
        <div v-if="loading" class="text-center">
            Loading...
        </div>
        <div v-else-if="records.length === 0" class="alert alert-info" role="alert">
            No records found.
        </div>
        <div v-else>
            <div v-for="(record, index) in records" :key="index" class="record">
                <div>
                    <strong>Name:</strong> {{ record.first_name }} {{ record.last_name }}<br>
                    <strong>Email:</strong> {{ record.email }}<br>
                    <strong>Phone:</strong> {{ record.phone_number }}
                </div>
                <div class="delete-button" @click="deleteRecord(index)">✕</div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.14/vue.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                records: [],
                loading: true
            },
            mounted() {
                this.fetchRecords(); // Initial fetch when the component is mounted
                setInterval(this.fetchRecords, 10000); // Fetch records every 10 seconds
            },
            methods: {
                fetchRecords() {
                    fetch('internal.php')
                        .then(response => response.json())
                        .then(data => {
                            this.records = data;
                            this.loading = false;
                        })
                        .catch(error => {
                            console.error('Error fetching records:', error);
                            this.loading = false;
                        });
                },
                deleteRecord(index) {
                    const recordId = this.records[index].id;
                    fetch(`delete.php?id=${recordId}`, { method: 'DELETE' })
                        .then(response => {
                            if (response.ok) {
                                this.records.splice(index, 1);
                            } else {
                                console.error('Error deleting record');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting record:', error);
                        });
                }
            }
        });
    </script>

</body>

</html>