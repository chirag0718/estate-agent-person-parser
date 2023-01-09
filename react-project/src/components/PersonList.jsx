import React from 'react';

import Person from "./Person";

const PersonList = (props) => {
    return (
        <table className="table">

            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">First Name</th>
                <th scope="col">Initial Name</th>
                <th scope="col">Last Name</th>
            </tr>
            </thead>
            <tbody>
            {props.persons.map((person) => (
                <Person
                    key={person.id}
                    title={person.title}
                    first_name={person.first_name}
                    last_name={person.last_name}
                    initial_name={person.initial_name}
                />
            ))}
            </tbody>

        </table>
    );
};

export default PersonList;
