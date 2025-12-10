import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";

function SettingsPage() {
  return (
    <div>
      <h2 className="mb-3">Settings</h2>
      <Card>
        <Card.Body>
          <Card.Title>Preferences</Card.Title>
          <Form className="mt-3">
            <Form.Group className="mb-3">
              <Form.Label>Store Name</Form.Label>
              <Form.Control placeholder="BreezeTech Admin" />
            </Form.Group>
            <Button variant="primary">Save Changes</Button>
          </Form>
        </Card.Body>
      </Card>
    </div>
  );
}

export default SettingsPage;

