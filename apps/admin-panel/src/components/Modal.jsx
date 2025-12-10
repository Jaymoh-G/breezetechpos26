import RBModal from "react-bootstrap/Modal";
import Button from "react-bootstrap/Button";

function Modal({ show, title, onClose, children, footer }) {
  return (
    <RBModal show={show} onHide={onClose} centered>
      {title && (
        <RBModal.Header closeButton>
          <RBModal.Title>{title}</RBModal.Title>
        </RBModal.Header>
      )}
      <RBModal.Body>{children}</RBModal.Body>
      {footer && (
        <RBModal.Footer>
          {footer}
          {!footer && (
            <Button variant="secondary" onClick={onClose}>
              Close
            </Button>
          )}
        </RBModal.Footer>
      )}
    </RBModal>
  );
}

export default Modal;

