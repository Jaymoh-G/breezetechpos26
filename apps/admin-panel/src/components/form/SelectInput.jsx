import Form from "react-bootstrap/Form";

function SelectInput({ label, name, value, onChange, options = [], required }) {
  return (
    <Form.Group className="mb-3">
      {label && <Form.Label>{label}</Form.Label>}
      <Form.Select name={name} value={value} onChange={onChange} required={required}>
        <option value="">Select...</option>
        {options.map((opt) => (
          <option key={opt.value} value={opt.value}>
            {opt.label}
          </option>
        ))}
      </Form.Select>
    </Form.Group>
  );
}

export default SelectInput;

