import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import Header from "../components/Header";

function SettingsPage() {
  return (
    <div>
      <Header title="Settings" />
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

