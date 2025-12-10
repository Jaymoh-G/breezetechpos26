import Form from "react-bootstrap/Form";

function TextInput({ label, name, value, onChange, type = "text", placeholder, required }) {
  return (
    <Form.Group className="mb-3">
      {label && <Form.Label>{label}</Form.Label>}
      <Form.Control
        name={name}
        value={value}
        onChange={onChange}
        type={type}
        placeholder={placeholder}
        required={required}
      />
    </Form.Group>
  );
}

export default TextInput;

