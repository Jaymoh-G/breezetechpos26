import Nav from "react-bootstrap/Nav";
import Card from "react-bootstrap/Card";
import { LinkContainer } from "react-router-bootstrap";

function Sidebar() {
  return (
    <Card className="rounded-0 min-vh-100 shadow-sm">
      <Card.Header className="fw-semibold">Navigation</Card.Header>
      <Nav className="flex-column p-2">
        <LinkContainer to="/">
          <Nav.Link>Overview</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/reports">
          <Nav.Link>Reports</Nav.Link>
        </LinkContainer>
        <LinkContainer to="/settings">
          <Nav.Link>Settings</Nav.Link>
        </LinkContainer>
      </Nav>
    </Card>
  );
}

export default Sidebar;

