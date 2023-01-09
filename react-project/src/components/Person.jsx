import React from 'react';

const Person = (props) => {
    return (
        <tr>
            <th className="row">{props.title}</th>
            <td>{props.first_name}</td>
            <td>{props.initial_name}</td>
            <td>{props.last_name}</td>
        </tr>
    );
};

export default Person;
