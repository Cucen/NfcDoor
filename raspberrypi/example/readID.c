#include "nfc.h"

#define  	NFC_DEMO_DEBUG 	1

void main(void) 
{
	uint32_t versiondata;
	uint32_t id;

#ifdef NFC_DEMO_DEBUG
	printf("Hello!\n");
#endif
	begin();
	versiondata = getFirmwareVersion();
	if (! versiondata) 
	{
		#ifdef NFC_DEMO_DEBUG
			printf("Didn't find PN53x board\n");
		#endif
		while (1); // halt
	}
	#ifdef NFC_DEMO_DEBUG
	// Got ok data, print it out!
	printf("Found chip PN5"); 
	printf("%x\n",((versiondata>>24) & 0xFF));
	printf("Firmware ver. "); 
	printf("%d",((versiondata>>16) & 0xFF));
	printf("."); 
	printf("%d\n",((versiondata>>8) & 0xFF));
	printf("Supports "); 
	printf("%x\n",(versiondata & 0xFF));
	#endif
	// configure board to read RFID tags and cards
	SAMConfig();
	
	while(1)
	{
		// look for MiFare type cards
		id = readPassiveTargetID(PN532_MIFARE_ISO14443A);
		if (id != 0) 
		{
		#ifdef NFC_DEMO_DEBUG
			printf("Read card #%d\n",id); 
		#endif
		}
	}
}


