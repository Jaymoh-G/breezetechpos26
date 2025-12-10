import Card from "react-bootstrap/Card";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import useAppStore from "../store/useAppStore";

function HomePage() {
  const user = useAppStore((state) => state.user);

  return (
    <div>
      <h2 className="mb-3">Dashboard</h2>
      <Row xs={1} md={2} className="g-3">
        <Col>
          <Card>
            <Card.Body>
              <Card.Title>Welcome, {user.name}</Card.Title>
              <Card.Text>Here is a quick snapshot of the admin panel.</Card.Text>
            </Card.Body>
          </Card>
        </Col>
        <Col>
          <Card>
            <Card.Body>
              <Card.Title>System Status</Card.Title>
              <Card.Text>All services are running normally.</Card.Text>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </div>
  );
}

export default HomePage;

