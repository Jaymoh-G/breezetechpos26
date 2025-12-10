import Navbar from "react-bootstrap/Navbar";
import Container from "react-bootstrap/Container";
import Button from "react-bootstrap/Button";
import useAppStore from "../store/useAppStore";

function Header({ title, actionLabel, onAction }) {
  const user = useAppStore((state) => state.user);

  return (
    <Navbar bg="white" className="shadow-sm rounded px-3 py-2 mb-3">
      <Container fluid className="px-0">
        <div>
          <Navbar.Brand className="mb-0 h5">{title}</Navbar.Brand>
          <div className="text-muted small">Signed in as {user.name || "Admin"}</div>
        </div>
        {actionLabel && (
          <Button variant="primary" onClick={onAction}>
            {actionLabel}
          </Button>
        )}
      </Container>
    </Navbar>
  );
}

export default Header;

