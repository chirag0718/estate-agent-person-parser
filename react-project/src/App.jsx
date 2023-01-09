import { useState} from 'react'
import './App.css'
import 'bootstrap/dist/css/bootstrap.min.css';
import axios from "axios";
import PersonList from "./components/PersonList.jsx";

function App() {
    const [csvFile, setCsvFile] = useState('')
    const [uploadCsvFileIsValid, setUploadCsvFileIsValid] = useState(true);
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [persons, setPersons] = useState([]);
    const [message, setMessage] = useState('');

    //
    const fileUploadChangeHandler = event => {
        setError(null)
        if (event.target.files.length > 0) {
            setCsvFile(event.target.files[0]);
            setUploadCsvFileIsValid(true)
        }
    }

    const csvUploadFileHandler = (event) => {
        event.preventDefault();
        if (csvFile === '') {
            setUploadCsvFileIsValid(false);
            return;
        }
        if (csvFile.name.split('.').pop() !== 'csv') {
            setError("File is empty or file format is not csv")
            document.querySelector("#imageForm").reset();
            return;
        }
        console.log(csvFile)
        const data = new FormData()
        data.append('csv_file', csvFile)

        axios.post("http://localhost:8000/api/v1/uploads", data, {
            method: "POST",
        }).then((response) => {
            if (response.status === 201) {
                setMessage(response.data.message);
            }
        }).catch((error) => {
            setError(error.response.data.message);
        });
        setCsvFile('')
        document.querySelector("#imageForm").reset();
        setUploadCsvFileIsValid(true)
    }


    const fetchPersonsHandler = () => {
        setMessage('');
        setUploadCsvFileIsValid(true);
        setIsLoading(true);
        axios.get("http://localhost:8000/api/v1/persons")
            .then((response) => {
                if (response.status === 200) {
                    const transformedPersons = response.data.map((personData) => {
                        return {
                            id: personData.id,
                            title: personData.title,
                            first_name: personData.first_name,
                            last_name: personData.last_name,
                            initial_name: personData.initial_name,
                        };
                    });
                    setPersons(transformedPersons);
                    setIsLoading(false);
                }
            }).catch((error) => {
            setError(error.message);
        });
    }

    const uploadFileClasses = uploadCsvFileIsValid ? 'form-control' : 'form-control is-invalid';

    let content = <p>Found no persons.</p>;

    if (persons.length > 0) {
        content = <PersonList persons={persons}/>;
    }

    if (error) {
        content = <div className="alert alert-danger">{error}</div>;
    }

    if (message) {
        content = <div className="alert alert-success">{message}</div>;
    }

    if (isLoading) {
        content = <p>Loading...</p>;
    }

    return (
        <div className="container">
            <div className="row">
                <h3>Street Group</h3>
                <form method="POST" onSubmit={csvUploadFileHandler} encType="multipart/form-data" id="imageForm">
                    <div className="mb-3">
                        <input name="csv_file" onChange={fileUploadChangeHandler} className={uploadFileClasses}
                               type="file" id="formFile"/>
                        {!uploadCsvFileIsValid && <p className="text-danger">File must not be empty</p>}
                        <br/>
                        <button type="submit" className="btn btn-success">
                            Upload CSV
                        </button>
                    </div>
                </form>

            </div>
            <div className="container">
                <div className="mb-3">
                    <button onClick={fetchPersonsHandler} type="button" className="btn btn-primary">
                        Fetch Person Data
                    </button>
                </div>
                <div className="row">
                    {content}
                </div>
            </div>
        </div>
    )
}

export default App
